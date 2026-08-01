<?php
namespace Database\Seeders;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Profil;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $client = User::create(['name'=>'Konan Adjoua','email'=>'client@devci.ci','password'=>Hash::make('password'),'role'=>'client','phone'=>'+225 07 12 34 56 78','city'=>'Abidjan']);

        $devsData = [
            ['name'=>'Kouamé Jean-Baptiste','email'=>'dev1@devci.ci','phone'=>'+225 05 11 22 33 44','city'=>'Abidjan','bio'=>'Développeur Full Stack passionné avec 5 ans d\'expérience. Spécialisé dans la création d\'applications web modernes avec Laravel et React.','specialite'=>'Développeur Full Stack','competences'=>['Laravel','React','MySQL','REST API','Docker','Git'],'disponibilite'=>'available','tarif_jour'=>75000,'annees_experience'=>5,'services'=>[['titre'=>'Site vitrine professionnel','description'=>'Création d\'un site web professionnel responsive avec CMS intégré, design moderne et SEO optimisé.','prix'=>250000,'delai'=>'2 semaines','categorie'=>'Web'],['titre'=>'Application web sur mesure','description'=>'Développement d\'une application web complète Laravel + React avec tests et déploiement.','prix'=>800000,'delai'=>'6 semaines','categorie'=>'Web'],['titre'=>'API REST Laravel','description'=>'Conception et développement d\'une API RESTful sécurisée avec documentation Swagger.','prix'=>350000,'delai'=>'3 semaines','categorie'=>'Backend']]],
            ['name'=>'Bamba Fatou','email'=>'dev2@devci.ci','phone'=>'+225 01 23 45 67 89','city'=>'Abidjan','bio'=>'Développeuse mobile Flutter certifiée Google. Je crée des applications iOS et Android performantes. Expertise UX/UI et intégration d\'APIs.','specialite'=>'Développeuse Mobile Flutter','competences'=>['Flutter','Dart','Firebase','iOS','Android','UX/UI'],'disponibilite'=>'available','tarif_jour'=>80000,'annees_experience'=>4,'services'=>[['titre'=>'Application mobile iOS/Android','description'=>'Développement cross-platform Flutter. Publication App Store et Google Play inclus.','prix'=>900000,'delai'=>'8 semaines','categorie'=>'Mobile'],['titre'=>'Intégration paiement mobile','description'=>'Intégration Wave, Orange Money et MTN Money dans votre app mobile.','prix'=>200000,'delai'=>'1 semaine','categorie'=>'Mobile']]],
            ['name'=>'Yao Constant','email'=>'dev3@devci.ci','phone'=>'+225 07 98 76 54 32','city'=>'Yamoussoukro','bio'=>'Expert WordPress et e-commerce avec 7 ans d\'expérience. J\'aide les entreprises ivoiriennes à développer leur présence en ligne avec WooCommerce.','specialite'=>'Expert WordPress & E-commerce','competences'=>['WordPress','WooCommerce','PHP','CSS','SEO','Elementor'],'disponibilite'=>'busy','tarif_jour'=>45000,'annees_experience'=>7,'services'=>[['titre'=>'Site WordPress complet','description'=>'Création d\'un site WordPress avec thème personnalisé, plugins essentiels et formation.','prix'=>180000,'delai'=>'10 jours','categorie'=>'Web'],['titre'=>'Boutique WooCommerce','description'=>'Mise en place d\'une boutique WooCommerce avec intégration paiement local.','prix'=>350000,'delai'=>'3 semaines','categorie'=>'E-commerce']]],
            ['name'=>'Diomandé Ibrahim','email'=>'dev4@devci.ci','phone'=>'+225 05 44 33 22 11','city'=>'Abidjan','bio'=>'Data Scientist et développeur Python. Je transforme vos données en insights actionnables et développe des solutions IA adaptées.','specialite'=>'Data Scientist & Python','competences'=>['Python','Machine Learning','Django','Pandas','TensorFlow','SQL'],'disponibilite'=>'available','tarif_jour'=>95000,'annees_experience'=>3,'services'=>[['titre'=>'Dashboard analytique','description'=>'Tableau de bord interactif pour visualiser et analyser vos données métier.','prix'=>450000,'delai'=>'4 semaines','categorie'=>'Data'],['titre'=>'Backend Python/Django','description'=>'Conception et développement backend robuste avec Django REST Framework.','prix'=>600000,'delai'=>'5 semaines','categorie'=>'Backend']]],
            ['name'=>'Touré Mariame','email'=>'dev5@devci.ci','phone'=>'+225 01 55 66 77 88','city'=>'Abidjan','bio'=>'Designer UI/UX et développeuse frontend. Je conçois des interfaces intuitives et élégantes qui améliorent l\'expérience utilisateur.','specialite'=>'Designer UI/UX & Frontend','competences'=>['Figma','Vue.js','React','HTML/CSS','Tailwind','Adobe XD'],'disponibilite'=>'available','tarif_jour'=>65000,'annees_experience'=>4,'services'=>[['titre'=>'Design UI/UX complet','description'=>'Maquettes Figma complètes avec guide de style, composants et prototype interactif.','prix'=>300000,'delai'=>'2 semaines','categorie'=>'Design'],['titre'=>'Intégration frontend','description'=>'Intégration pixel-perfect de vos maquettes en React ou Vue.js avec animations.','prix'=>400000,'delai'=>'3 semaines','categorie'=>'Frontend']]],
            ['name'=>'N\'Guessan Aristide','email'=>'dev6@devci.ci','phone'=>'+225 07 00 11 22 33','city'=>'Bouaké','bio'=>'Développeur Node.js et architecte cloud. Je construis des architectures évolutives pour applications à fort trafic avec AWS et CI/CD.','specialite'=>'Développeur Node.js & DevOps','competences'=>['Node.js','Express','AWS','Docker','MongoDB','CI/CD'],'disponibilite'=>'available','tarif_jour'=>90000,'annees_experience'=>6,'services'=>[['titre'=>'Architecture microservices','description'=>'Conception et mise en place d\'une architecture microservices scalable avec Node.js et Docker.','prix'=>1200000,'delai'=>'10 semaines','categorie'=>'Backend'],['titre'=>'Déploiement DevOps','description'=>'Configuration pipeline CI/CD, déploiement cloud et monitoring de votre application.','prix'=>350000,'delai'=>'2 semaines','categorie'=>'DevOps']]],
        ];

        $firstDev = null;
        foreach ($devsData as $i => $d) {
            $user = User::create(['name'=>$d['name'],'email'=>$d['email'],'password'=>Hash::make('password'),'role'=>'developer','phone'=>$d['phone'],'city'=>$d['city']]);
            if ($i === 0) $firstDev = $user;
            Profil::create(['user_id'=>$user->id,'bio'=>$d['bio'],'specialite'=>$d['specialite'],'competences'=>$d['competences'],'disponibilite'=>$d['disponibilite'],'tarif_jour'=>$d['tarif_jour'],'annees_experience'=>$d['annees_experience'],'vues'=>rand(12,340)]);
            foreach ($d['services'] as $svc) {
                Service::create(array_merge($svc,['user_id'=>$user->id]));
            }
        }

        $conv = Conversation::create(['client_id'=>$client->id,'developer_id'=>$firstDev->id,'sujet'=>'Développement boutique e-commerce','description_projet'=>'Boutique en ligne pour produits artisanaux ivoiriens.','budget_propose'=>500000,'statut'=>'en_cours','last_message_at'=>now()]);
        $msgs=[[$client->id,'Bonjour Kouamé ! J\'ai vu votre profil, je suis impressionné. J\'aimerais discuter d\'un projet de boutique en ligne.'],[$firstDev->id,'Bonjour Konan ! Merci. Dites-moi en plus sur votre projet, je suis disponible.'],[$client->id,'Je vends des produits artisanaux : tissus, bijoux, sculptures. J\'ai besoin d\'une boutique avec paiement Wave et Orange Money.'],[$firstDev->id,'Parfait, c\'est mon domaine ! Mon estimation est de 600 000 FCFA pour 5 semaines. Qu\'en pensez-vous ?'],[$client->id,'Mon budget est de 500 000 FCFA. On peut s\'entendre ?'],[$firstDev->id,'Oui ! On démarre avec les essentiels pour 500 000 FCFA et on ajoute les options plus tard. Je vous prépare un devis !']];
        foreach ($msgs as $i => [$sid,$txt]) {
            Message::create(['conversation_id'=>$conv->id,'sender_id'=>$sid,'contenu'=>$txt,'lu'=>true,'lu_at'=>now()->subMinutes(count($msgs)-$i),'created_at'=>now()->subMinutes(count($msgs)-$i),'updated_at'=>now()->subMinutes(count($msgs)-$i)]);
        }

        $this->command->info('Données démo créées !');
        $this->command->table(['Rôle','Email','Mot de passe'],[['Client','client@devci.ci','password'],['Dev 1','dev1@devci.ci','password'],['Dev 2','dev2@devci.ci','password']]);
    }
}
