<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index()
    {
        $user      = Auth::user();
        $paiements = $user->isClient()
            ? Paiement::where('client_id', $user->id)->with('developer','conversation')->latest()->paginate(10)
            : Paiement::where('developer_id', $user->id)->with('client','conversation')->latest()->paginate(10);

        return view('payments.index', compact('paiements', 'user'));
    }

    public function initiate(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            'montant'         => 'required|integer|min:500',
            'methode'         => 'required|in:wave,orange_money',
        ]);

        $user         = Auth::user();
        $conversation = Conversation::where('id', $request->conversation_id)
            ->where('client_id', $user->id)
            ->firstOrFail();

        $paiement = Paiement::create([
            'conversation_id' => $conversation->id,
            'client_id'       => $user->id,
            'developer_id'    => $conversation->developer_id,
            'montant'         => $request->montant,
            'methode'         => $request->methode,
            'statut'          => 'en_attente',
            'reference'       => Paiement::generateReference(),
        ]);

        // Redirection vers l'opérateur
        if ($request->methode === 'wave') {
            return $this->initiateWave($paiement);
        }
        return $this->initiateOrangeMoney($paiement);
    }

    private function initiateWave(Paiement $paiement)
    {
        // Intégration Wave CI
        // https://developer.wave.com/
        $callbackUrl = route('payments.wave.callback') . '?ref=' . $paiement->reference;
        $cancelUrl   = route('payments.show', $paiement->id);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.wave.api_key'),
                'Content-Type'  => 'application/json',
            ])->post('https://api.wave.com/v1/checkout/sessions', [
                'amount'       => $paiement->montant,
                'currency'     => 'XOF',
                'error_url'    => $cancelUrl,
                'success_url'  => $callbackUrl,
                'client_reference' => $paiement->reference,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $paiement->update(['meta' => $data]);
                return redirect($data['wave_launch_url']);
            }
        } catch (\Exception $e) {
            // En mode dev, simuler
        }

        // Mode démo (pas de clé API configurée)
        return redirect()->route('payments.show', $paiement->id)
            ->with('info', '🔧 Mode démo : configurez WAVE_API_KEY dans .env pour activer le paiement réel.');
    }

    private function initiateOrangeMoney(Paiement $paiement)
    {
        // Intégration Orange Money CI
        // https://developer.orange.com/apis/om-webpay-ci/
        try {
            $tokenResponse = Http::withHeaders([
                'Authorization' => 'Basic ' . config('services.orange_money.auth_header'),
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ])->asForm()->post('https://api.orange.com/oauth/v3/token', [
                'grant_type' => 'client_credentials',
            ]);

            if ($tokenResponse->successful()) {
                $token = $tokenResponse->json()['access_token'];
                $callbackUrl = route('payments.orange.callback') . '?ref=' . $paiement->reference;

                $payResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                ])->post('https://api.orange.com/orange-money-webpay/ci/v1/webpayment', [
                    'merchant_key' => config('services.orange_money.merchant_key'),
                    'currency'     => 'OUV',
                    'order_id'     => $paiement->reference,
                    'amount'       => $paiement->montant,
                    'return_url'   => $callbackUrl,
                    'cancel_url'   => route('payments.show', $paiement->id),
                    'notif_url'    => $callbackUrl,
                    'lang'         => 'fr',
                ]);

                if ($payResponse->successful()) {
                    $data = $payResponse->json();
                    $paiement->update(['meta' => $data]);
                    return redirect($data['payment_url']);
                }
            }
        } catch (\Exception $e) {
            // En mode dev, simuler
        }

        return redirect()->route('payments.show', $paiement->id)
            ->with('info', '🔧 Mode démo : configurez ORANGE_MONEY_* dans .env pour activer le paiement réel.');
    }

    public function waveCallback(Request $request)
    {
        $paiement = Paiement::where('reference', $request->ref)->firstOrFail();
        $paiement->update(['statut' => 'paye', 'paye_at' => now()]);
        $paiement->conversation->update(['statut' => 'en_cours']);

        return redirect()->route('payments.show', $paiement->id)
            ->with('success', '✅ Paiement Wave confirmé !');
    }

    public function orangeCallback(Request $request)
    {
        $paiement = Paiement::where('reference', $request->ref)->firstOrFail();
        $paiement->update([
            'statut'         => 'paye',
            'transaction_id' => $request->txnid,
            'paye_at'        => now(),
        ]);
        $paiement->conversation->update(['statut' => 'en_cours']);

        return redirect()->route('payments.show', $paiement->id)
            ->with('success', '✅ Paiement Orange Money confirmé !');
    }

    public function show(int $id)
    {
        $user     = Auth::user();
        $paiement = Paiement::where(function ($q) use ($user) {
                $q->where('client_id', $user->id)->orWhere('developer_id', $user->id);
            })->with('conversation','client','developer')->findOrFail($id);

        return view('payments.show', compact('paiement'));
    }
}
