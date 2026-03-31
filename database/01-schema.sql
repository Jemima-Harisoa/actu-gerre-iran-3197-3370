-- ============================================
-- Base de données Iran Actu - Schema SQL
-- ============================================

-- Créer la base de données
DROP DATABASE iran_actu;
CREATE DATABASE IF NOT EXISTS iran_actu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE iran_actu;
SET CHARACTER SET utf8mb4;
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ============================================
-- Table Categories (Rubriques)
-- ============================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table Articles
-- ============================================
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(500),
    content LONGTEXT,
    author VARCHAR(150),
    image_url VARCHAR(500),
    is_featured BOOLEAN DEFAULT 0,
    published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_published (published_at),
    INDEX idx_featured (is_featured)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table Statuts (Pour la diffusion en direct)
-- ============================================
CREATE TABLE IF NOT EXISTS statuts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table Diffusion (En Direct)
-- Référence la table statuts
-- ============================================
CREATE TABLE IF NOT EXISTS diffusion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(500) NOT NULL,
    status_id INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (status_id) REFERENCES statuts(id) ON DELETE RESTRICT,
    INDEX idx_status (status_id),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table Article Images (Images multiples)
-- ============================================
CREATE TABLE IF NOT EXISTS article_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    caption VARCHAR(500),
    position INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    INDEX idx_article (article_id),
    INDEX idx_position (position)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Insérer les catégories par défaut
-- ============================================
INSERT INTO categories (name, slug) VALUES
('International', 'international'),
('Politique', 'politique'),
('Société', 'societe'),
('Économie', 'economie'),
('Culture', 'culture'),
('Idées', 'idees'),
('Planète', 'planete'),
('Sciences', 'sciences'),
('Sport', 'sport'),
('Tech', 'tech'),
('M Le Mag', 'm-le-mag');

INSERT INTO statuts (name, description) VALUES
('en_cours', 'Actualité en cours - En direct'),
('fini', 'Actualité terminée - Archived'),
('a_predire', 'Actualité à venir - À prédire');

-- ============================================
-- Insérer des diffusions de test
-- ============================================
INSERT INTO diffusion (title, status_id) VALUES
('Guerre en Iran : nouvelles frappes sur Téhéran dans la nuit du vendredi au samedi', 2),
('Moyen-Orient : Israël annonce une trêve humanitaire de 8 heures à Gaza', 1),
('Ukraine : la France va livrer 12 chasseurs Mirage 2000 supplémentaires à Kiev', 3),
('Économie : la BCE maintient ses taux directeurs inchangés pour le troisième trimestre', 1);

-- ============================================
-- RESET
-- ============================================
DELETE FROM article_images;
DELETE FROM articles;

-- ============================================
-- ARTICLES - Images via Pexels CDN (hotlink autorisé, libres de droit)
-- URLs directes .jpg, pas de redirect Unsplash/Wikimedia
-- ============================================

INSERT INTO articles (category_id, title, description, content, author, image_url, is_featured, published_at) VALUES

-- ============================================
-- 1. INTERNATIONAL — missiles / guerre / explosion
-- https://www.pexels.com/photo/soldier-running-on-field-with-smoke-1004409/
-- ============================================
(
  1,
  'Guerre Iran-Israël : les frappes de missiles redessinent le Moyen-Orient',
  'La guerre Iran-Israël entre dans une nouvelle phase avec des échanges de missiles balistiques sans précédent depuis octobre 2024.',
  '<p>La <strong>guerre Iran</strong>-Israël a franchi un nouveau seuil de dangerosité en octobre 2024, lorsque l''Iran a lancé une salve de plus de 180 missiles balistiques en direction d''Israël. Cette escalade dans la <strong>guerre Iran</strong>-Israël a immédiatement provoqué l''activation du système de défense antimissile israélien Iron Dome et Arrow 3, interceptant la grande majorité des projectiles.</p>

  <p>La <strong>guerre Iran</strong>-Israël ne se limite plus aux escarmouches par procuration via le Hezbollah ou le Hamas : désormais, les deux États s''affrontent directement. La <strong>guerre Iran</strong> contre Israël marque un tournant dans l''histoire du Moyen-Orient. Selon les analystes de l''Institut international d''études stratégiques (IISS), la <strong>guerre Iran</strong> mène une stratégie d''usure visant à saturer les capacités défensives israéliennes.</p>

  <p>Dans le contexte de la <strong>guerre Iran</strong>-Israël, les États-Unis ont renforcé leur présence militaire dans la région en déployant deux groupes aéronavals supplémentaires en Méditerranée orientale. La <strong>guerre Iran</strong> implique désormais indirectement l''ensemble des grandes puissances mondiales. La Russie et la Chine observent l''évolution de la <strong>guerre Iran</strong> avec un intérêt stratégique évident, cherchant à exploiter l''affaiblissement de l''influence américaine au Proche-Orient.</p>

  <p>Les Nations Unies ont convoqué en urgence le Conseil de sécurité pour discuter de la <strong>guerre Iran</strong>-Israël. Le Secrétaire général de l''ONU a appelé à un cessez-le-feu immédiat, soulignant que la <strong>guerre Iran</strong> risque de déstabiliser l''ensemble de la région. Malgré ces appels, la <strong>guerre Iran</strong>-Israël continue de s''intensifier, avec des frappes israéliennes ciblant les infrastructures militaires iraniennes.</p>

  <p>Les experts en géopolitique estiment que la <strong>guerre Iran</strong>-Israël pourrait durer encore plusieurs années. La <strong>guerre Iran</strong> a d''ores et déjà causé des milliers de victimes civiles et militaires des deux côtés. Face à la <strong>guerre Iran</strong>, les pays arabes voisins comme la Jordanie et l''Arabie saoudite se retrouvent dans une position délicate, tiraillés entre leurs alliances traditionnelles et la menace que représente l''escalade de la <strong>guerre Iran</strong> pour leur propre stabilité.</p>',
  'Rédaction Internationale',
  '/../inc/uploads/3580cabbe44c3f01e730a730a07cbdf7.avif?auto=compress&cs=tinysrgb&w=800',
  1,
  '2026-03-15 08:30:00'
),

-- ============================================
-- 2. POLITIQUE — parlement / discours / gouvernement
-- https://www.pexels.com/photo/flags-and-governmental-building-2391/
-- ============================================
(
  2,
  'Guerre en Iran : le régime des Ayatollahs sous pression intérieure',
  'La guerre en Iran fragilise le pouvoir du Guide suprême Ali Khamenei, confronté à une opposition grandissante à l''intérieur du pays.',
  '<p>La <strong>guerre Iran</strong> produit des effets dévastateurs sur la cohésion politique interne du régime islamique. Depuis le déclenchement de la <strong>guerre Iran</strong>-Israël, le Guide suprême Ali Khamenei fait face à une contestation sans précédent au sein même des cercles du pouvoir. La <strong>guerre Iran</strong> a révélé des fractures profondes entre les factions conservatrices et pragmatistes au sein du gouvernement iranien.</p>

  <p>Le président Masoud Pezeshkian, élu en juillet 2024 sur une plateforme réformiste, se trouve dans une position particulièrement délicate face à la <strong>guerre Iran</strong>. Bien que favorable à une désescalade, Pezeshkian est contraint de soutenir publiquement la politique militaire de la <strong>guerre Iran</strong> dictée par Khamenei. Cette tension entre la ligne réformiste et la logique de la <strong>guerre Iran</strong> paralyse en partie la prise de décision politique.</p>

  <p>La <strong>guerre Iran</strong> a également renforcé le pouvoir des Gardiens de la Révolution (CGRI), qui profitent du contexte de la <strong>guerre Iran</strong> pour étendre leur influence sur l''économie et la société civile. Plusieurs anciens hauts responsables politiques ont été arrêtés depuis le début de la <strong>guerre Iran</strong>, accusés d''avoir eu des contacts avec des puissances étrangères hostiles.</p>

  <p>Les mouvements sociaux nés de la révolution "Femme, Vie, Liberté" de 2022 tentent de profiter du contexte de la <strong>guerre Iran</strong> pour revendiquer davantage de droits. Cependant, la <strong>guerre Iran</strong> sert également de prétexte au régime pour justifier une répression accrue. La <strong>guerre Iran</strong> est ainsi instrumentalisée politiquement par Khamenei pour consolider son pouvoir face aux critiques internes.</p>

  <p>Sur la scène diplomatique, la <strong>guerre Iran</strong> a conduit à la rupture des négociations sur le programme nucléaire avec les puissances occidentales. L''accord de Vienne (JCPOA), déjà moribond, est définitivement enterré depuis le début de la <strong>guerre Iran</strong>. Les perspectives d''un règlement pacifique de la <strong>guerre Iran</strong> semblent de plus en plus lointaines.</p>',
  'Correspondant Politique — Téhéran',
  '/../inc/uploads/iran-ayatomerde.jpeg?auto=compress&cs=tinysrgb&w=800',
  0,
  '2026-03-20 11:00:00'
),

-- ============================================
-- 3. SOCIÉTÉ — foule / rue / population civile
-- https://www.pexels.com/photo/people-walking-on-street-2467558/
-- ============================================
(
  3,
  'Guerre en Iran : la population civile prise en étau entre les bombes et la pauvreté',
  'La guerre en Iran dévaste le quotidien de 87 millions d''Iraniens, contraints de survivre dans un pays en guerre et sous sanctions économiques.',
  '<p>La <strong>guerre Iran</strong> ne se vit pas seulement sur les champs de bataille. Pour les 87 millions de citoyens iraniens, la <strong>guerre Iran</strong> se traduit au quotidien par des pénuries alimentaires, des coupures de courant, et une inflation galopante qui dépasse les 40 % selon les chiffres officiels. La réalité de la <strong>guerre Iran</strong> pour les Iraniens ordinaires est bien plus brutale que ce que montrent les discours officiels du régime.</p>

  <p>À Téhéran, la capitale iranienne meurtrie par la <strong>guerre Iran</strong>, les habitants racontent les nuits passées dans les abris, les files d''attente interminables devant les boulangeries, les hôpitaux débordés par les blessés de la <strong>guerre Iran</strong>. Les femmes iraniennes, déjà en première ligne de la résistance sociale avant la <strong>guerre Iran</strong>, portent désormais le double fardeau du conflit armé et de l''oppression politique.</p>

  <p>La <strong>guerre Iran</strong> a provoqué une vague d''exode sans précédent. Depuis le début de la <strong>guerre Iran</strong>, près de 2 millions d''Iraniens ont fui le pays, principalement vers la Turquie, l''Allemagne et le Canada. Cette diaspora de la <strong>guerre Iran</strong> constitue une perte dramatique de capital humain pour un pays dont l''avenir dépend pourtant de sa jeunesse éduquée.</p>

  <p>Les organisations humanitaires internationales, notamment le CICR et MSF (Médecins Sans Frontières), tentent d''accéder aux zones touchées par la <strong>guerre Iran</strong>. Mais la <strong>guerre Iran</strong> rend l''acheminement de l''aide humanitaire extrêmement difficile. Les corridors humanitaires négociés dans le cadre de la <strong>guerre Iran</strong> sont régulièrement violés par toutes les parties au conflit.</p>

  <p>Les communautés ethniques minoritaires — Kurdes, Baloutches, Arabes du Khuzestan — subissent de plein fouet les conséquences de la <strong>guerre Iran</strong>. La <strong>guerre Iran</strong> risque de raviver des tensions ethniques latentes qui pourraient, à terme, menacer l''intégrité territoriale de la République islamique.</p>',
  'Rédaction Société',
  '/../inc/uploads/941426_484.jpg?auto=compress&cs=tinysrgb&w=800',
  0,
  '2026-02-28 14:45:00'
),

-- ============================================
-- 4. ÉCONOMIE — pétrole / industrie / raffinerie
-- https://www.pexels.com/photo/gray-and-black-industrial-machine-1108101/
-- ============================================
(
  4,
  'Guerre en Iran : l''économie pétrolière s''effondre sous le poids des sanctions et du conflit',
  'La guerre en Iran a fait chuter la production pétrolière iranienne de 40%, plongeant dans la misère une économie déjà fragilisée par des années de sanctions.',
  '<p>La <strong>guerre Iran</strong> a porté un coup fatal à l''économie iranienne, déjà fragilisée par des décennies de sanctions internationales. Depuis le début de la <strong>guerre Iran</strong>, la production pétrolière du pays est tombée à moins de 2 millions de barils par jour, contre 3,8 millions avant le conflit. La <strong>guerre Iran</strong> a ainsi privé Téhéran de sa principale source de revenus en devises étrangères.</p>

  <p>Le rial iranien, déjà en chute libre avant la <strong>guerre Iran</strong>, a perdu 60 % de sa valeur supplémentaire depuis le début des hostilités. La <strong>guerre Iran</strong> a transformé la crise monétaire en catastrophe économique nationale. Les économistes spécialisés sur la <strong>guerre Iran</strong> estiment que le PIB iranien pourrait reculer de 15 à 20 % sur l''année 2025-2026.</p>

  <p>Le détroit d''Ormuz, par lequel transitent 20 % des exportations mondiales de pétrole, est au cœur des enjeux économiques de la <strong>guerre Iran</strong>. L''Iran a menacé à plusieurs reprises de bloquer ce passage stratégique en réponse aux pressions militaires liées à la <strong>guerre Iran</strong>. Une telle mesure dans le cadre de la <strong>guerre Iran</strong> ferait exploser les prix mondiaux du pétrole.</p>

  <p>Les Gardiens de la Révolution, qui contrôlent une part importante de l''économie iranienne depuis bien avant la <strong>guerre Iran</strong>, profitent paradoxalement du chaos engendré par la <strong>guerre Iran</strong> pour renforcer leur emprise sur les secteurs stratégiques. La <strong>guerre Iran</strong> a ainsi accéléré le processus de "militarisation" de l''économie iranienne.</p>

  <p>Sur les marchés internationaux, la <strong>guerre Iran</strong> a créé une volatilité extrême des cours du pétrole et du gaz naturel. Les pays européens redoutent que la <strong>guerre Iran</strong> ne vienne aggraver leurs difficultés d''approvisionnement. La <strong>guerre Iran</strong> s''inscrit dans un contexte géopolitique global marqué par une fragmentation des marchés énergétiques mondiaux.</p>',
  'Rédaction Économie',
  '/../inc/uploads/f1181db6-bfb3-441a-93f1-08dd0db5b15f.jpg?auto=compress&cs=tinysrgb&w=800',
  0,
  '2026-03-05 09:15:00'
),

-- ============================================
-- 5. CULTURE — architecture / mosquée / patrimoine
-- https://www.pexels.com/photo/mosque-under-blue-sky-3822120/
-- ============================================
(
  5,
  'Guerre en Iran : les artistes et intellectuels iraniens face au silence imposé',
  'La guerre en Iran réduit au silence une scène culturelle parmi les plus riches du monde musulman. Cinéastes, poètes et musiciens paient un lourd tribut au conflit.',
  '<p>La <strong>guerre Iran</strong> frappe de plein fouet l''une des cultures les plus anciennes et les plus riches de l''humanité. L''Iran, berceau de la poésie de Rumi et Hafez, voit sa vie culturelle anéantie par la <strong>guerre Iran</strong>. Les musées de Téhéran, d''Ispahan et de Shiraz ont fermé leurs portes depuis le début de la <strong>guerre Iran</strong>, par mesure de sécurité.</p>

  <p>Le cinéma iranien, mondialement reconnu grâce aux œuvres d''Asghar Farhadi (deux fois oscarisé), vit une période sombre à cause de la <strong>guerre Iran</strong>. Plusieurs cinéastes majeurs ont fui le pays depuis le début de la <strong>guerre Iran</strong>. La <strong>guerre Iran</strong> rend impossible tout tournage normal, entre les restrictions de déplacement, les coupures de courant et la censure omniprésente.</p>

  <p>La musique iranienne subit également les conséquences de la <strong>guerre Iran</strong>. Les concerts sont interdits en Iran, et la <strong>guerre Iran</strong> a encore renforcé ces restrictions. Les musiciens iraniens de la diaspora, dispersés entre Los Angeles, Paris et Toronto, utilisent leurs instruments pour témoigner de la <strong>guerre Iran</strong> et maintenir vivante la flamme d''une culture menacée.</p>

  <p>Le patrimoine archéologique iranien, classé en partie par l''UNESCO, est particulièrement vulnérable face à la <strong>guerre Iran</strong>. Le site de Persépolis se trouve à moins de 60 km de zones de combats liés à la <strong>guerre Iran</strong>. Les archéologues internationaux tirent la sonnette d''alarme : la <strong>guerre Iran</strong> pourrait causer des dommages irréparables à des sites vieux de 2 500 ans.</p>

  <p>Malgré la <strong>guerre Iran</strong>, la résistance culturelle s''organise. Sur les réseaux sociaux — malgré la censure liée à la <strong>guerre Iran</strong> — des poètes iraniens publient des textes dénonçant à la fois le conflit et l''oppression. Cette poésie de la <strong>guerre Iran</strong> trouve un écho mondial et rappelle que la culture iranienne a déjà survécu à bien des invasions avant la <strong>guerre Iran</strong> actuelle.</p>',
  'Rédaction Culture',
  '/../inc/uploads/0_ysS8EwD19seDAh-p.jpg?auto=compress&cs=tinysrgb&w=800',
  0,
  '2026-01-18 16:00:00'
),

-- ============================================
-- 6. IDÉES — carte / géopolitique / monde
-- https://www.pexels.com/photo/world-map-1796715/
-- ============================================
(
  6,
  'Guerre en Iran : décryptage d''une guerre aux racines historiques et idéologiques profondes',
  'La guerre en Iran n''est pas née en 2024. Elle est l''aboutissement de décennies de rivalités géopolitiques, religieuses et nucléaires entre Téhéran et Jérusalem.',
  '<p>Pour comprendre la <strong>guerre Iran</strong>-Israël, il faut remonter à la révolution islamique de 1979. C''est à partir de cette date que l''Iran, autrefois allié d''Israël sous le Shah, est devenu son ennemi juré. La <strong>guerre Iran</strong> actuelle est donc l''aboutissement d''une hostilité idéologique de 45 ans.</p>

  <p>La <strong>guerre Iran</strong> s''inscrit également dans le cadre de la rivalité entre l''axe chiite, conduit par Téhéran, et l''axe sunnite, conduit par l''Arabie saoudite. La <strong>guerre Iran</strong> est aussi une guerre de religion au sein de l''islam. Cette dimension confessionnelle de la <strong>guerre Iran</strong> explique pourquoi les pays sunnites comme l''Égypte et la Jordanie refusent de soutenir l''Iran malgré leur hostilité traditionnelle à Israël.</p>

  <p>La question nucléaire est au cœur des enjeux de la <strong>guerre Iran</strong>. Israël ne peut pas accepter qu''un pays dont les dirigeants ont explicitement appelé à sa destruction dispose de l''arme nucléaire. C''est ce calcul existentiel qui a conduit Israël à mener des frappes préventives contre les installations nucléaires iraniennes, précipitant le début de la <strong>guerre Iran</strong>.</p>

  <p>D''autres analystes interprètent la <strong>guerre Iran</strong> comme le produit des échecs diplomatiques successifs de la communauté internationale. L''abandon du JCPOA par Trump en 2018, les sanctions renforcées, l''assassinat du général Soleimani en 2020 : autant d''événements qui ont rendu la <strong>guerre Iran</strong> inévitable selon cette lecture.</p>

  <p>Quelles que soient ses origines, la <strong>guerre Iran</strong> pose des questions philosophiques et éthiques fondamentales. Peut-on justifier une guerre préventive comme Israël l''a fait pour lancer la <strong>guerre Iran</strong> ? Ces débats sur la légitimité de la <strong>guerre Iran</strong> agitent les think tanks, les universités et les chancelleries du monde entier.</p>',
  'Tribune — Jean-Pierre Filiu, professeur à Sciences Po',
  '/../inc/uploads/AA1YPGQg.jpg?auto=compress&cs=tinysrgb&w=800',
  0,
  '2026-02-10 10:30:00'
),

-- ============================================
-- 7. PLANÈTE — fumée / pollution / incendie industriel
-- https://www.pexels.com/photo/silhouette-of-factory-929385/
-- ============================================
(
  7,
  'Guerre en Iran : un désastre environnemental silencieux aux conséquences mondiales',
  'La guerre en Iran laisse des traces profondes sur l''environnement : puits de pétrole en feu, contamination des eaux, nuages de fumée toxique au-dessus du Golfe Persique.',
  '<p>La <strong>guerre Iran</strong> constitue une catastrophe environnementale dont l''ampleur reste largement sous-estimée. Depuis le début de la <strong>guerre Iran</strong>, plusieurs puits de pétrole dans la province du Khuzestan ont été incendiés, dégageant des colonnes de fumée noire visibles depuis l''espace. La <strong>guerre Iran</strong> remet tragiquement en mémoire les images des puits de pétrole koweïtiens en feu lors de la guerre du Golfe de 1991.</p>

  <p>Le Golfe Persique, mer semi-fermée particulièrement fragile sur le plan écologique, absorbe de plein fouet les conséquences maritimes de la <strong>guerre Iran</strong>. Les hydrocarbures déversés lors des combats navals de la <strong>guerre Iran</strong> dans le détroit d''Ormuz menacent des écosystèmes marins uniques.</p>

  <p>Les experts du GIEC et de l''UNEP ont publié des rapports alarmants sur l''impact climatique de la <strong>guerre Iran</strong>. Les émissions de CO2 générées directement par les opérations militaires de la <strong>guerre Iran</strong> s''ajoutent aux incendies de végétation provoqués par les combats. La <strong>guerre Iran</strong> contribue ainsi à l''accélération du réchauffement climatique dans une région déjà l''une des plus touchées au monde.</p>

  <p>Les nappes phréatiques iraniennes subissent une contamination accrue par les métaux lourds issus des munitions utilisées dans la <strong>guerre Iran</strong>. Les rivières Karoun et Karun, vitales pour l''irrigation du Khuzestan, portent désormais les traces chimiques de la <strong>guerre Iran</strong>. Cette contamination hydrique de la <strong>guerre Iran</strong> aura des conséquences sanitaires pour plusieurs générations.</p>

  <p>Les ONG environnementales plaident pour que, quelle que soit l''issue de la <strong>guerre Iran</strong>, un plan de décontamination et de restauration écologique massif soit mis en place dès la fin des hostilités. La <strong>guerre Iran</strong> aura laissé des cicatrices environnementales qui dureront des décennies.</p>',
  'Rédaction Planète',
  '/../inc/uploads/R.jpg?auto=compress&cs=tinysrgb&w=800',
  0,
  '2026-01-05 08:00:00'
),

-- ============================================
-- 8. SCIENCES — laboratoire / nucléaire / recherche
-- https://www.pexels.com/photo/person-in-laboratory-2280571/
-- ============================================
(
  8,
  'Guerre en Iran : le programme nucléaire iranien sous les bombes, la science en otage',
  'La guerre en Iran a détruit ou fortement endommagé plusieurs installations nucléaires, plongeant dans l''incertitude l''avenir du programme atomique de Téhéran.',
  '<p>La <strong>guerre Iran</strong> a ciblé en priorité les installations nucléaires iraniennes, considérées par Israël comme la principale menace existentielle. Depuis le début de la <strong>guerre Iran</strong>, les sites d''enrichissement d''uranium de Natanz et de Fordow ont été frappés à plusieurs reprises. La <strong>guerre Iran</strong> a ainsi fait reculer d''au moins cinq ans les capacités nucléaires iraniennes, selon les estimations de l''AIEA.</p>

  <p>Au-delà du nucléaire militaire, la <strong>guerre Iran</strong> a également sinistré la recherche scientifique civile iranienne. Les universités de Téhéran, Ispahan et Chiraz ont vu leur corps enseignant décimé par l''exode des cerveaux provoqué par la <strong>guerre Iran</strong>. La <strong>guerre Iran</strong> a ainsi renforcé le phénomène de "brain drain" qui privait déjà l''Iran de ses meilleurs chercheurs.</p>

  <p>Le programme spatial iranien est désormais à l''arrêt depuis la <strong>guerre Iran</strong>. La base de lancement de Shahroud a été frappée au début de la <strong>guerre Iran</strong>. La <strong>guerre Iran</strong> met fin à l''ambition iranienne de devenir une puissance spatiale régionale, ambition qui servait aussi de couverture au programme balistique militaire directement lié à la <strong>guerre Iran</strong>.</p>

  <p>La médecine iranienne souffre également de la <strong>guerre Iran</strong>. Les hôpitaux débordés par les blessés de la <strong>guerre Iran</strong> manquent de médicaments, d''équipements et de personnel qualifié. La <strong>guerre Iran</strong> a rendu impossible l''importation de nombreux médicaments essentiels. Les malades chroniques et les cancéreux sont les premières victimes invisibles de la <strong>guerre Iran</strong>.</p>

  <p>Des scientifiques iraniens de la diaspora ont fondé, en réponse à la <strong>guerre Iran</strong>, le collectif "Science for Iran Peace". Ce collectif né de la <strong>guerre Iran</strong> plaide pour que la reconstruction scientifique de l''Iran soit une priorité internationale dès la fin de la <strong>guerre Iran</strong>.</p>',
  'Rédaction Sciences',
  '/../inc/uploads/les-sites-du-programme-nucleaire-iranien-3b42fe-0@1x.jpeg?auto=compress&cs=tinysrgb&w=800',
  0,
  '2026-03-01 12:00:00'
),

-- ============================================
-- 9. SPORT — stade / football / supporters
-- https://www.pexels.com/photo/stadium-stands-during-game-46798/
-- ============================================
(
  9,
  'Guerre en Iran : les sportifs iraniens entre exil et résistance, le sport comme dernier refuge',
  'La guerre en Iran n''a pas éteint la flamme sportive d''un peuple qui trouve dans le football, la lutte et le taekwondo un espace de dignité et d''identité nationale.',
  '<p>La <strong>guerre Iran</strong> n''a pas réussi à éteindre la passion sportive du peuple iranien. Malgré les bombes et les privations engendrées par la <strong>guerre Iran</strong>, des milliers d''Iraniens continuent de pratiquer le sport comme un acte de résistance et de survie psychologique. La <strong>guerre Iran</strong> a certes détruit des stades et des infrastructures sportives, mais n''a pas détruit la culture sportive profondément enracinée dans la société iranienne.</p>

  <p>La Fédération internationale de football (FIFA) a suspendu l''équipe nationale iranienne des compétitions internationales depuis le début de la <strong>guerre Iran</strong>, invoquant l''impossibilité d''organiser des matchs en toute sécurité. Cette décision liée à la <strong>guerre Iran</strong> a suscité une vive émotion en Iran, où le football est bien plus qu''un simple sport.</p>

  <p>Les athlètes iraniens à l''étranger se retrouvent dans une situation particulièrement difficile depuis la <strong>guerre Iran</strong>. Plusieurs d''entre eux ont demandé l''asile politique dans leurs pays d''accueil depuis le déclenchement de la <strong>guerre Iran</strong>. La <strong>guerre Iran</strong> a ainsi créé une diaspora sportive qui tente de maintenir le flambeau du sport iranien hors du pays en guerre.</p>

  <p>La lutte traditionnelle iranienne (varzesh-e bastani), vieille de 3 000 ans, continue d''être pratiquée dans les zoorkhaneh qui ont miraculeusement survécu à la <strong>guerre Iran</strong>. La perpétuation de cette pratique ancestrale malgré la <strong>guerre Iran</strong> est perçue par beaucoup d''Iraniens comme un symbole de la résilience de leur civilisation face à la <strong>guerre Iran</strong>.</p>

  <p>Le Comité International Olympique (CIO) a créé un fonds spécial pour les athlètes iraniens déplacés par la <strong>guerre Iran</strong>. Le CIO espère que ces athlètes de la <strong>guerre Iran</strong> pourront représenter un Iran pacifié lors des prochains Jeux Olympiques, symbolisant la renaissance d''un pays ravagé par la <strong>guerre Iran</strong>.</p>',
  'Rédaction Sport',
  '/../inc/uploads/file-20200220-92518-13lqfhh.avif?auto=compress&cs=tinysrgb&w=800',
  0,
  '2026-02-14 18:30:00'
),

-- ============================================
-- 10. TECH — cybersécurité / serveurs / données
-- https://www.pexels.com/photo/blue-and-green-peacock-feather-325185/
-- Image : datacenter / serveurs
-- https://www.pexels.com/photo/turned-on-computer-monitors-1714208/
-- ============================================
(
  10,
  'Guerre en Iran : la cyberguerre, front invisible d''un conflit qui se joue aussi dans le numérique',
  'La guerre en Iran a ouvert un nouveau front dans le cyberespace. Les attaques informatiques iraniennes contre les infrastructures israéliennes et occidentales atteignent une ampleur sans précédent.',
  '<p>La <strong>guerre Iran</strong> se mène désormais sur deux théâtres simultanés : le terrain physique et le cyberespace. Depuis le déclenchement de la <strong>guerre Iran</strong>, les services de renseignement occidentaux ont documenté une multiplication par cinq des cyberattaques attribuées à des groupes liés au gouvernement iranien. La <strong>guerre Iran</strong> numérique cible en priorité les infrastructures critiques israéliennes — réseau électrique, eau potable, systèmes bancaires.</p>

  <p>Les groupes de hackers iraniens les plus actifs dans la <strong>guerre Iran</strong> numérique portent des noms évocateurs : APT33 (Elfin), APT34 (OilRig), Charming Kitten. Ces entités, directement liées aux Gardiens de la Révolution, ont intensifié leurs opérations depuis le début de la <strong>guerre Iran</strong>. La <strong>guerre Iran</strong> dans le cyberespace se caractérise par des attaques sophistiquées de type "supply chain".</p>

  <p>En riposte, les unités cyber de l''armée israélienne (Unit 8200) ont mené leurs propres opérations offensives dans le cadre de la <strong>guerre Iran</strong>. Des infrastructures industrielles iraniennes, notamment des systèmes SCADA contrôlant des pipelines pétroliers, ont été ciblées. Cette escalade numérique de la <strong>guerre Iran</strong> rappelle l''opération Stuxnet de 2010, qui avait déjà préfiguré la dimension cyber de la <strong>guerre Iran</strong> actuelle.</p>

  <p>La <strong>guerre Iran</strong> pose des questions inédites sur le droit international applicable aux cyberconflits. Contrairement aux missiles et aux bombes de la <strong>guerre Iran</strong> conventionnelle, les cyberattaques de la <strong>guerre Iran</strong> numérique ne laissent pas toujours de traces probantes permettant d''établir la responsabilité.</p>

  <p>Pour les citoyens iraniens, la <strong>guerre Iran</strong> numérique se traduit par une surveillance accrue de leurs communications. Le gouvernement utilise la <strong>guerre Iran</strong> comme prétexte pour renforcer son "internet national" (SHOMA). La <strong>guerre Iran</strong> numérique a ainsi un double visage : offensive à l''extérieur, répressive à l''intérieur pour contrôler les récits de la <strong>guerre Iran</strong>.</p>',
  'Rédaction Tech',
  '/../inc/uploads/1000_F_785056389_UwpMcIfwgNutoYZgL709tipiOIpszq9B.jpg?auto=compress&cs=tinysrgb&w=800',
  0,
  '2026-03-22 07:45:00'
),

-- ============================================
-- 11. M LE MAG — femmes / portrait / humanité
-- https://www.pexels.com/photo/woman-holding-a-candle-1642883/
-- ============================================
(
  11,
  'Guerre en Iran : histoires de femmes iraniennes qui résistent, survivent et espèrentGuerre en Iran : histoires de femmes iraniennes qui résistent, survivent et espèrent',
  'La guerre en Iran a un visage de femme. Reportage sur ces Iraniennes qui continuent de se battre pour leur dignité, au péril de leur vie, malgré les bombes et la répression.',
  '<p>Narges a 34 ans. Depuis le début de la <strong>guerre Iran</strong>, elle n''a pas quitté Téhéran, même quand ses amies lui conseillaient de fuir. "La <strong>guerre Iran</strong> ne me fera pas partir de ma ville", dit-elle avec une détermination tranquille. Médecin dans un hôpital du sud de la capitale, Narges soigne chaque jour les victimes de la <strong>guerre Iran</strong> : des enfants brûlés, des soldats mutilés, des civils traumatisés.</p>

  <p>Shirin, 28 ans, est poète. Avant la <strong>guerre Iran</strong>, elle publiait ses textes sur Instagram sous son vrai nom. Depuis que la <strong>guerre Iran</strong> a durci la censure, elle écrit sous pseudonyme et diffuse ses poèmes de la <strong>guerre Iran</strong> sur des canaux cryptés. Ses vers parlent de la <strong>guerre Iran</strong> sans jamais prononcer ce mot — par métaphore, par allusion, comme ses illustres prédécesseurs persans le faisaient pour parler des tyrans.</p>

  <p>Maryam, 45 ans, a perdu son fils dans la <strong>guerre Iran</strong>. Il avait 19 ans et avait été mobilisé de force six mois après le début du conflit. La <strong>guerre Iran</strong> lui a pris son unique enfant. Depuis, Maryam s''est jointe au mouvement des "Mères en noir", ces femmes iraniennes qui refusent le silence sur le deuil que leur impose la <strong>guerre Iran</strong>.</p>

  <p>Leila, 52 ans, est cheffe cuisinière. Son restaurant dans le quartier de Vanak à Téhéran est l''un des rares à avoir résisté à la crise économique engendrée par la <strong>guerre Iran</strong>. Elle cuisine des plats traditionnels iraniens — ghormeh sabzi, fesenjan, ash reshteh — comme un acte de résistance culturelle contre la <strong>guerre Iran</strong>.</p>

  <p>Ces quatre femmes incarnent la résilience d''un peuple meurtri par la <strong>guerre Iran</strong> mais refusant de se laisser réduire à son statut de victime. Comme l''a écrit la poétesse Forugh Farrokhzad bien avant la <strong>guerre Iran</strong> actuelle : "Je crois au jardin. Je crois au jardin." Malgré la <strong>guerre Iran</strong>, les jardins iraniens continuent de fleurir.</p>',
  'Marie Jego — Grand Reportage',
  '/../inc/uploads/1200x680_capture-femmes-iraniennes.jpg?auto=compress&cs=tinysrgb&w=800',
  0,
  '2026-03-08 09:00:00'
);