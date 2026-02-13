<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        // ── Property Types ──────────────────
        $types = [
            ['name' => ['en' => 'Apartment', 'sq' => 'Apartament'], 'slug' => 'apartment', 'icon' => '🏢'],
            ['name' => ['en' => 'House', 'sq' => 'Shtëpi'], 'slug' => 'house', 'icon' => '🏠'],
            ['name' => ['en' => 'Villa', 'sq' => 'Vilë'], 'slug' => 'villa', 'icon' => '🏡'],
            ['name' => ['en' => 'Penthouse', 'sq' => 'Penthouse'], 'slug' => 'penthouse', 'icon' => '🏙️'],
            ['name' => ['en' => 'Land', 'sq' => 'Tokë'], 'slug' => 'land', 'icon' => '🌍'],
            ['name' => ['en' => 'Commercial', 'sq' => 'Komerciale'], 'slug' => 'commercial', 'icon' => '🏬'],
        ];

        foreach ($types as $type) {
            PropertyType::updateOrCreate(['slug' => $type['slug']], $type);
        }

        // ── Demo Agents ──────────────────
        $agents = [];
        $agentData = [
            ['name' => 'Arlind Hoxha', 'email' => 'arlind@prokos.demo', 'agency_name' => 'ProKos Real Estate', 'license_number' => 'KS-2024-001'],
            ['name' => 'Elira Berisha', 'email' => 'elira@prokos.demo', 'agency_name' => 'Prishtina Homes', 'license_number' => 'KS-2024-002'],
            ['name' => 'Besart Krasniqi', 'email' => 'besart@prokos.demo', 'agency_name' => 'Kosovo Properties', 'license_number' => 'KS-2024-003'],
        ];

        foreach ($agentData as $data) {
            $agents[] = User::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password' => bcrypt('password'),
                    'role' => 'agent',
                    'is_verified' => true,
                    'bio' => 'Experienced real estate agent with over 10 years of expertise in the Kosovo property market. Specializing in residential and commercial properties.',
                    'phone' => '+383 49 ' . rand(100000, 999999),
                ])
            );
        }

        // ── Unsplash Images ──────────────────
        $images = [
            'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80',
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80',
            'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80',
            'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=80',
            'https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?w=800&q=80',
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=800&q=80',
            'https://images.unsplash.com/photo-1613977257363-707ba9348227?w=800&q=80',
            'https://images.unsplash.com/photo-1600573472591-ee6981cf81d6?w=800&q=80',
            'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=800&q=80',
            'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80',
            'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&q=80',
        ];

        // ── Properties across ALL Kosovo cities ──────────────────
        $properties = [
            // ─── Prishtina ───
            [
                'title' => ['en' => 'Luxury 3+1 Apartment in Prishtina City Center', 'sq' => 'Apartament luksoz 3+1 në qendër të Prishtinës'],
                'description' => ['en' => 'Stunning modern apartment featuring panoramic city views, open-plan living with high-end finishes, floor-to-ceiling windows, and a spacious balcony. Located in the heart of Prishtina, walking distance to the National Library and main boulevard.', 'sq' => 'Apartament modern mahnitës me pamje panoramike të qytetit, jetesë e hapur me përfundime të nivelit të lartë, dritare nga dyshemeja deri në tavan dhe ballkon i gjerë. I vendosur në zemrën e Prishtinës, pranë Bibliotekës Kombëtare dhe bulevardit kryesor.'],
                'listing_type' => 'sale', 'price' => 185000, 'city' => 'Prishtina', 'address' => 'Bulevardi Nënë Tereza 45',
                'bedrooms' => 3, 'bathrooms' => 2, 'area_sqm' => 120, 'year_built' => 2023, 'floors' => 1,
                'features' => ['Parking', 'Balcony', 'Elevator', 'Air Conditioning', 'Central Heating'],
                'is_featured' => true, 'property_type' => 'apartment',
            ],
            [
                'title' => ['en' => 'Elegant Penthouse with Rooftop Terrace in Prishtina', 'sq' => 'Penthouse elegant me tarracë në çati në Prishtinë'],
                'description' => ['en' => 'Exclusive penthouse with a private rooftop terrace offering 360-degree views of Prishtina. Features smart home system, designer interior, and premium finishes. Located in the Arbëria neighborhood.', 'sq' => 'Penthouse ekskluziv me tarracë private në çati që ofron pamje 360 gradë të Prishtinës. Me sistem shtëpie inteligjente, dizajn enterier dhe përfundime premium. I vendosur në lagjen Arbëria.'],
                'listing_type' => 'sale', 'price' => 320000, 'city' => 'Prishtina', 'address' => 'Lagja Arbëria, Rruga B',
                'bedrooms' => 3, 'bathrooms' => 2, 'area_sqm' => 180, 'year_built' => 2024, 'floors' => 1,
                'features' => ['Terrace', 'Elevator', 'Air Conditioning', 'Central Heating', 'Security System', 'Mountain View'],
                'is_featured' => true, 'property_type' => 'penthouse',
            ],
            [
                'title' => ['en' => 'Cozy Studio for Rent near University of Prishtina', 'sq' => 'Garsonjera komode me qira pranë Universitetit të Prishtinës'],
                'description' => ['en' => 'Charming studio apartment fully furnished, perfect for students or young professionals. Walking distance to the University of Prishtina and Germia Park.', 'sq' => 'Apartament garsonjere i mobiluar plotësisht, perfekt për studentë ose profesionistë të rinj. Në distancë ecjeje nga Universiteti i Prishtinës dhe Parku i Gërmisë.'],
                'listing_type' => 'rent', 'price' => 300, 'city' => 'Prishtina', 'address' => 'Rruga Agim Ramadani 12',
                'bedrooms' => 1, 'bathrooms' => 1, 'area_sqm' => 45, 'year_built' => 2021, 'floors' => 1,
                'features' => ['Furnished', 'Air Conditioning', 'Elevator'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],
            [
                'title' => ['en' => 'Furnished Office Space for Rent – Prishtina', 'sq' => 'Zyrë e mobiluar me qira – Prishtinë'],
                'description' => ['en' => 'Professional office space with modern furniture, high-speed internet, and meeting room. Located on the main boulevard in Prishtina\'s business district.', 'sq' => 'Hapësirë zyre profesionale me mobilie moderne, internet me shpejtësi të lartë dhe dhomë mbledhjesh. E vendosur në bulevardin kryesor në distriktin e biznesit të Prishtinës.'],
                'listing_type' => 'rent', 'price' => 500, 'city' => 'Prishtina', 'address' => 'Bulevardi Bill Clinton',
                'bedrooms' => 0, 'bathrooms' => 1, 'area_sqm' => 100, 'year_built' => 2019, 'floors' => 1,
                'features' => ['Furnished', 'Air Conditioning', 'Elevator', 'Parking', 'Security System'],
                'is_featured' => false, 'property_type' => 'commercial',
            ],

            // ─── Prizren ───
            [
                'title' => ['en' => 'Traditional Stone House in Old Town Prizren', 'sq' => 'Shtëpi e vjetër me gurë në Qytetin e Vjetër të Prizrenit'],
                'description' => ['en' => 'Beautifully restored traditional stone house in the historic old town of Prizren. Features original stonework, wooden beams, courtyard garden, and views of Prizren Fortress.', 'sq' => 'Shtëpi tradicionale me gurë e restauruar bukur në qytetin historik të vjetër të Prizrenit. Me punë origjinale guri, trarë druri, kopsht oborri dhe pamje të Kalasë së Prizrenit.'],
                'listing_type' => 'sale', 'price' => 145000, 'city' => 'Prizren', 'address' => 'Shadervan, Qyteti i Vjetër',
                'bedrooms' => 4, 'bathrooms' => 2, 'area_sqm' => 200, 'year_built' => 1890, 'floors' => 2,
                'features' => ['Garden', 'Fireplace', 'Mountain View', 'Storage Room'],
                'is_featured' => true, 'property_type' => 'house',
            ],
            [
                'title' => ['en' => 'Modern 2+1 Apartment in Prizren with River View', 'sq' => 'Apartament modern 2+1 në Prizren me pamje lumi'],
                'description' => ['en' => 'Newly built apartment overlooking the Bistrica River. Modern kitchen, spacious living room, and balcony with stunning views of the Sharr Mountains.', 'sq' => 'Apartament i ndërtuar rishtazi me pamje mbi Lumin Bistrica. Kuzhinë moderne, dhomë ditore e gjerë dhe ballkon me pamje mahnitëse të Maleve Sharr.'],
                'listing_type' => 'sale', 'price' => 95000, 'city' => 'Prizren', 'address' => 'Rruga Remzi Ademaj 8',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 85, 'year_built' => 2022, 'floors' => 1,
                'features' => ['Balcony', 'Central Heating', 'Elevator', 'Mountain View'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],

            // ─── Peja / Pejë ───
            [
                'title' => ['en' => 'Villa with Garden near Rugova Canyon', 'sq' => 'Vilë me kopsht pranë Kanionit të Rugovës'],
                'description' => ['en' => 'Exquisite villa with lush garden and mountain views near the famous Rugova Canyon. 4 spacious bedrooms, modern kitchen, outdoor entertainment area, and private parking.', 'sq' => 'Vilë e shkëlqyer me kopsht të gjelbër dhe pamje malesh pranë Kanionit të famshëm të Rugovës. 4 dhoma gjumi të gjera, kuzhinë moderne, zonë argëtimi jashtë dhe parking privat.'],
                'listing_type' => 'sale', 'price' => 280000, 'city' => 'Pejë', 'address' => 'Rruga e Rugovës 15',
                'bedrooms' => 4, 'bathrooms' => 3, 'area_sqm' => 260, 'year_built' => 2021, 'floors' => 2,
                'features' => ['Garden', 'Parking', 'Air Conditioning', 'Mountain View', 'Terrace', 'Fireplace', 'Security System'],
                'is_featured' => true, 'property_type' => 'villa',
            ],

            // ─── Gjakova ───
            [
                'title' => ['en' => 'Spacious Family Home in Gjakova', 'sq' => 'Shtëpi familjare e gjerë në Gjakovë'],
                'description' => ['en' => 'Large family home with beautiful garden, garage, and quiet neighborhood in Gjakova. Close to the historic Çarshia e Madhe bazaar and city center.', 'sq' => 'Shtëpi e madhe familjare me kopsht të bukur, garazh dhe lagje të qetë në Gjakovë. Pranë Çarshisë së Madhe historike dhe qendrës së qytetit.'],
                'listing_type' => 'sale', 'price' => 110000, 'city' => 'Gjakovë', 'address' => 'Lagja Dardanisë',
                'bedrooms' => 5, 'bathrooms' => 2, 'area_sqm' => 220, 'year_built' => 2016, 'floors' => 2,
                'features' => ['Garden', 'Parking', 'Central Heating', 'Storage Room', 'Fireplace'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Mitrovica ───
            [
                'title' => ['en' => '2+1 Apartment for Rent in Mitrovica', 'sq' => 'Apartament 2+1 me qira në Mitrovicë'],
                'description' => ['en' => 'Well-maintained apartment in central Mitrovica. Near schools, parks, and public transport. Fully renovated with modern bathroom and kitchen.', 'sq' => 'Apartament i mirëmbajtur në qendër të Mitrovicës. Pranë shkollave, parqeve dhe transportit publik. I renovuar plotësisht me banjo dhe kuzhinë moderne.'],
                'listing_type' => 'rent', 'price' => 250, 'city' => 'Mitrovicë', 'address' => 'Rruga Mbretëresha Teutë',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 75, 'year_built' => 2018, 'floors' => 1,
                'features' => ['Central Heating', 'Balcony', 'Elevator'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],

            // ─── Ferizaj ───
            [
                'title' => ['en' => 'New Build Apartment Complex in Ferizaj', 'sq' => 'Kompleks apartamentesh të reja në Ferizaj'],
                'description' => ['en' => 'Brand new 2+1 apartment in a modern residential complex. Underground parking, elevator, and children\'s playground. Close to the highway connecting Prishtina and Skopje.', 'sq' => 'Apartament krejtësisht i ri 2+1 në kompleks rezidencial modern. Parking nëntokësor, ashensor dhe këndi i lojërave për fëmijë. Pranë autostradës që lidh Prishtinën me Shkupin.'],
                'listing_type' => 'sale', 'price' => 82000, 'city' => 'Ferizaj', 'address' => 'Lagja Dëshmorët e Kombit',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 78, 'year_built' => 2024, 'floors' => 1,
                'features' => ['Parking', 'Elevator', 'Central Heating', 'Balcony'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],

            // ─── Gjilan ───
            [
                'title' => ['en' => 'Commercial Space in Gjilan Downtown', 'sq' => 'Hapësirë komerciale në qendër të Gjilanit'],
                'description' => ['en' => 'Prime commercial space on the main street. Ideal for retail, office, or restaurant. High foot traffic area with excellent visibility in Gjilan city center.', 'sq' => 'Hapësirë komerciale premium në rrugën kryesore. Ideale për dyqan, zyrë ose restorant. Zonë me trafik të lartë këmbësorësh në qendër të Gjilanit.'],
                'listing_type' => 'rent', 'price' => 600, 'city' => 'Gjilan', 'address' => 'Bulevardi i Pavarësisë',
                'bedrooms' => 0, 'bathrooms' => 1, 'area_sqm' => 130, 'year_built' => 2017, 'floors' => 1,
                'features' => ['Parking', 'Air Conditioning', 'Security System'],
                'is_featured' => false, 'property_type' => 'commercial',
            ],

            // ─── Suhareka ───
            [
                'title' => ['en' => 'Building Land in Suhareka – 600m²', 'sq' => 'Tokë ndërtimi në Suharekë – 600m²'],
                'description' => ['en' => 'Prime building land on the outskirts of Suhareka with good road access. Ideal for residential development. All permits available.', 'sq' => 'Tokë ndërtimi premium në periferi të Suharekës me akses të mirë rrugor. Ideale për zhvillim rezidencial. Të gjitha lejet e disponueshme.'],
                'listing_type' => 'sale', 'price' => 45000, 'city' => 'Suharekë', 'address' => 'Zona Industriale, Suharekë',
                'bedrooms' => 0, 'bathrooms' => 0, 'area_sqm' => 600, 'year_built' => null, 'floors' => 0,
                'features' => [],
                'is_featured' => false, 'property_type' => 'land',
            ],

            // ─── Rahovec ───
            [
                'title' => ['en' => 'Vineyard Estate with House in Rahovec', 'sq' => 'Pronë me vreshta dhe shtëpi në Rahovec'],
                'description' => ['en' => 'Unique property featuring a traditional house surrounded by vineyards in Kosovo\'s wine capital. Perfect for agricultural investment or rural retreat.', 'sq' => 'Pronë unike me shtëpi tradicionale të rrethuar me vreshta në kryeqytetin e verës së Kosovës. Perfekte për investim bujqësor ose strehim rural.'],
                'listing_type' => 'sale', 'price' => 120000, 'city' => 'Rahovec', 'address' => 'Zona e Vreshtave',
                'bedrooms' => 3, 'bathrooms' => 1, 'area_sqm' => 180, 'year_built' => 2000, 'floors' => 1,
                'features' => ['Garden', 'Parking', 'Mountain View', 'Storage Room'],
                'is_featured' => true, 'property_type' => 'house',
            ],

            // ─── Lipjan ───
            [
                'title' => ['en' => 'Modern House near Prishtina in Lipjan', 'sq' => 'Shtëpi moderne pranë Prishtinës në Lipjan'],
                'description' => ['en' => 'Newly built house in Lipjan, just 15 minutes from Prishtina. Spacious garden, modern design, garage for 2 cars, and quiet residential area.', 'sq' => 'Shtëpi e ndërtuar rishtazi në Lipjan, vetëm 15 minuta nga Prishtina. Kopsht i gjerë, dizajn modern, garazh për 2 makina dhe zonë rezidenciale e qetë.'],
                'listing_type' => 'sale', 'price' => 175000, 'city' => 'Lipjan', 'address' => 'Lagja e Re, Lipjan',
                'bedrooms' => 4, 'bathrooms' => 2, 'area_sqm' => 240, 'year_built' => 2023, 'floors' => 2,
                'features' => ['Garden', 'Parking', 'Central Heating', 'Balcony', 'Terrace', 'Storage Room'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Podujevë ───
            [
                'title' => ['en' => 'Affordable 1+1 Apartment in Podujevë', 'sq' => 'Apartament i përballueshëm 1+1 në Podujevë'],
                'description' => ['en' => 'Affordable newly renovated apartment in Podujevë center. Perfect for first-time buyers or as an investment property with good rental potential.', 'sq' => 'Apartament i përballueshëm i renovuar rishtazi në qendër të Podujevës. Perfekt për blerës të parë ose si pronë investimi me potencial të mirë qiraje.'],
                'listing_type' => 'sale', 'price' => 48000, 'city' => 'Podujevë', 'address' => 'Rruga Skënderbeu',
                'bedrooms' => 1, 'bathrooms' => 1, 'area_sqm' => 55, 'year_built' => 2020, 'floors' => 1,
                'features' => ['Central Heating', 'Balcony'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],

            // ─── Vushtrri ───
            [
                'title' => ['en' => 'Family House with Large Garden in Vushtrri', 'sq' => 'Shtëpi familjare me kopsht të madh në Vushtrri'],
                'description' => ['en' => 'Spacious family house with a large garden in a quiet Vushtrri neighborhood. Recently renovated, close to schools and local amenities.', 'sq' => 'Shtëpi familjare e gjerë me kopsht të madh në lagje të qetë të Vushtrrisë. E renovuar së fundmi, pranë shkollave dhe shërbimeve lokale.'],
                'listing_type' => 'sale', 'price' => 88000, 'city' => 'Vushtrri', 'address' => 'Lagja Gumnishte',
                'bedrooms' => 3, 'bathrooms' => 2, 'area_sqm' => 190, 'year_built' => 2010, 'floors' => 2,
                'features' => ['Garden', 'Parking', 'Central Heating', 'Storage Room'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Drenas / Gllogoc ───
            [
                'title' => ['en' => 'New Apartment in Drenas Center', 'sq' => 'Apartament i ri në qendër të Drenasit'],
                'description' => ['en' => 'Brand new 2+1 apartment in Drenas town center. Modern building with elevator, underground parking, and close to all amenities.', 'sq' => 'Apartament krejtësisht i ri 2+1 në qendër të Drenasit. Ndërtesë moderne me ashensor, parking nëntokësor dhe pranë të gjitha shërbimeve.'],
                'listing_type' => 'sale', 'price' => 65000, 'city' => 'Drenas', 'address' => 'Qendra, Drenas',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 72, 'year_built' => 2024, 'floors' => 1,
                'features' => ['Parking', 'Elevator', 'Central Heating'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],

            // ─── Skenderaj ───
            [
                'title' => ['en' => 'Building Plot in Skenderaj', 'sq' => 'Parcelë ndërtimi në Skenderaj'],
                'description' => ['en' => 'Flat building plot in a developing residential area in Skenderaj. All utilities nearby, suitable for house or small building.', 'sq' => 'Parcelë e rrafshët ndërtimi në zonë rezidenciale në zhvillim në Skenderaj. Të gjitha shërbimet afër, e përshtatshme për shtëpi ose ndërtesë të vogël.'],
                'listing_type' => 'sale', 'price' => 25000, 'city' => 'Skenderaj', 'address' => 'Lagja e Re, Skenderaj',
                'bedrooms' => 0, 'bathrooms' => 0, 'area_sqm' => 400, 'year_built' => null, 'floors' => 0,
                'features' => [],
                'is_featured' => false, 'property_type' => 'land',
            ],

            // ─── Deçan ───
            [
                'title' => ['en' => 'Mountain View Villa in Deçan', 'sq' => 'Vilë me pamje malesh në Deçan'],
                'description' => ['en' => 'Beautiful villa with panoramic mountain views near the Deçan Monastery and Bjeshkët e Nemuna national park. Perfect holiday retreat.', 'sq' => 'Vilë e bukur me pamje panoramike malesh pranë Manastirit të Deçanit dhe parkut kombëtar Bjeshkët e Nemuna. Strehim perfekt pushimi.'],
                'listing_type' => 'sale', 'price' => 195000, 'city' => 'Deçan', 'address' => 'Rruga për Bjeshkë',
                'bedrooms' => 3, 'bathrooms' => 2, 'area_sqm' => 200, 'year_built' => 2022, 'floors' => 2,
                'features' => ['Garden', 'Mountain View', 'Fireplace', 'Parking', 'Terrace'],
                'is_featured' => true, 'property_type' => 'villa',
            ],

            // ─── Istog ───
            [
                'title' => ['en' => 'Renovated House with Orchard in Istog', 'sq' => 'Shtëpi e renovuar me pemishte në Istog'],
                'description' => ['en' => 'Beautifully renovated house with a fruit orchard near the Istog springs. Peaceful countryside living with modern comforts.', 'sq' => 'Shtëpi e renovuar bukur me pemishte pranë burimeve të Istogut. Jetesë e qetë fshatare me komoditete moderne.'],
                'listing_type' => 'sale', 'price' => 78000, 'city' => 'Istog', 'address' => 'Burimi, Istog',
                'bedrooms' => 3, 'bathrooms' => 1, 'area_sqm' => 150, 'year_built' => 1985, 'floors' => 2,
                'features' => ['Garden', 'Parking', 'Fireplace', 'Storage Room'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Klinë ───
            [
                'title' => ['en' => 'Commercial Property for Rent in Klinë', 'sq' => 'Pronë komerciale me qira në Klinë'],
                'description' => ['en' => 'Well-located commercial space on the main road through Klinë. Suitable for shop, cafe, or office. Good visibility and parking.', 'sq' => 'Hapësirë komerciale e vendosur mirë në rrugën kryesore të Klinës. E përshtatshme për dyqan, kafene ose zyrë. Vizibilitet i mirë dhe parking.'],
                'listing_type' => 'rent', 'price' => 350, 'city' => 'Klinë', 'address' => 'Rruga Kryesore, Klinë',
                'bedrooms' => 0, 'bathrooms' => 1, 'area_sqm' => 80, 'year_built' => 2015, 'floors' => 1,
                'features' => ['Parking', 'Air Conditioning'],
                'is_featured' => false, 'property_type' => 'commercial',
            ],

            // ─── Malishevë ───
            [
                'title' => ['en' => 'Land for Sale in Malishevë', 'sq' => 'Tokë për shitje në Malishevë'],
                'description' => ['en' => 'Large plot of agricultural land suitable for farming or future development. Located near the main road with easy access.', 'sq' => 'Parcelë e madhe toke bujqësore e përshtatshme për bujqësi ose zhvillim të ardhshëm. E vendosur pranë rrugës kryesore me akses të lehtë.'],
                'listing_type' => 'sale', 'price' => 30000, 'city' => 'Malishevë', 'address' => 'Zona Bujqësore, Malishevë',
                'bedrooms' => 0, 'bathrooms' => 0, 'area_sqm' => 1000, 'year_built' => null, 'floors' => 0,
                'features' => [],
                'is_featured' => false, 'property_type' => 'land',
            ],

            // ─── Kaçanik ───
            [
                'title' => ['en' => '2+1 Apartment with Highway Access in Kaçanik', 'sq' => 'Apartament 2+1 me akses autostradale në Kaçanik'],
                'description' => ['en' => 'Convenient apartment in Kaçanik with excellent highway access to both Prishtina and Skopje. Modern building with all amenities.', 'sq' => 'Apartament i përshtatshëm në Kaçanik me akses të shkëlqyer autostradale për Prishtinë dhe Shkup. Ndërtesë moderne me të gjitha shërbimet.'],
                'listing_type' => 'sale', 'price' => 58000, 'city' => 'Kaçanik', 'address' => 'Qendra, Kaçanik',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 70, 'year_built' => 2021, 'floors' => 1,
                'features' => ['Central Heating', 'Balcony', 'Parking'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],

            // ─── Shtime ───
            [
                'title' => ['en' => 'Affordable House in Shtime', 'sq' => 'Shtëpi e përballueshme në Shtime'],
                'description' => ['en' => 'Affordable family house in Shtime with garden and parking. Recently renovated, close to the center and main road to Ferizaj.', 'sq' => 'Shtëpi familjare e përballueshme në Shtime me kopsht dhe parking. E renovuar së fundmi, pranë qendrës dhe rrugës kryesore për Ferizaj.'],
                'listing_type' => 'sale', 'price' => 55000, 'city' => 'Shtime', 'address' => 'Lagja Qendrore, Shtime',
                'bedrooms' => 3, 'bathrooms' => 1, 'area_sqm' => 140, 'year_built' => 2005, 'floors' => 2,
                'features' => ['Garden', 'Parking', 'Central Heating'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Obiliq ───
            [
                'title' => ['en' => 'Industrial Land near Obiliq', 'sq' => 'Tokë industriale pranë Obiliqit'],
                'description' => ['en' => 'Large industrial plot near Obiliq with highway access. Close to Kosovo\'s energy infrastructure. Ideal for warehouse or factory.', 'sq' => 'Parcelë e madhe industriale pranë Obiliqit me akses autostradale. Pranë infrastrukturës energjetike të Kosovës. Ideale për depo ose fabrikë.'],
                'listing_type' => 'sale', 'price' => 70000, 'city' => 'Obiliq', 'address' => 'Zona Industriale, Obiliq',
                'bedrooms' => 0, 'bathrooms' => 0, 'area_sqm' => 2000, 'year_built' => null, 'floors' => 0,
                'features' => [],
                'is_featured' => false, 'property_type' => 'land',
            ],

            // ─── Fushë Kosovë ───
            [
                'title' => ['en' => 'Modern Apartment near Train Station in Fushë Kosovë', 'sq' => 'Apartament modern pranë stacionit të trenit në Fushë Kosovë'],
                'description' => ['en' => 'Well-connected apartment near Fushë Kosovë train station. Modern building, 10 minutes from Prishtina Airport and city center.', 'sq' => 'Apartament i lidhur mirë pranë stacionit të trenit në Fushë Kosovë. Ndërtesë moderne, 10 minuta nga Aeroporti i Prishtinës dhe qendra e qytetit.'],
                'listing_type' => 'sale', 'price' => 72000, 'city' => 'Fushë Kosovë', 'address' => 'Lagja pranë Stacionit',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 68, 'year_built' => 2022, 'floors' => 1,
                'features' => ['Elevator', 'Central Heating', 'Parking'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],

            // ─── Hani i Elezit ───
            [
                'title' => ['en' => 'Border Town Apartment in Hani i Elezit', 'sq' => 'Apartament në qytetin kufitar Hani i Elezit'],
                'description' => ['en' => 'Budget-friendly apartment in the border town of Hani i Elezit. Strategic location between Kosovo and North Macedonia.', 'sq' => 'Apartament me çmim të përballueshëm në qytetin kufitar Hani i Elezit. Vendndodhje strategjike mes Kosovës dhe Maqedonisë së Veriut.'],
                'listing_type' => 'sale', 'price' => 35000, 'city' => 'Hani i Elezit', 'address' => 'Qendra, Hani i Elezit',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 60, 'year_built' => 2015, 'floors' => 1,
                'features' => ['Central Heating', 'Balcony'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],

            // ─── Kamenicë ───
            [
                'title' => ['en' => 'Countryside Home with Land in Kamenicë', 'sq' => 'Shtëpi fshatare me tokë në Kamenicë'],
                'description' => ['en' => 'Charming countryside home with 500m² of land in the Kamenicë municipality. Peaceful environment, perfect for nature lovers.', 'sq' => 'Shtëpi fshatare tërheqëse me 500m² tokë në komunën e Kamenicës. Mjedis i qetë, perfekt për adhuruesit e natyrës.'],
                'listing_type' => 'sale', 'price' => 42000, 'city' => 'Kamenicë', 'address' => 'Lagja Qendrore, Kamenicë',
                'bedrooms' => 3, 'bathrooms' => 1, 'area_sqm' => 130, 'year_built' => 1995, 'floors' => 1,
                'features' => ['Garden', 'Parking', 'Storage Room'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Viti ───
            [
                'title' => ['en' => 'Apartment for Rent in Viti', 'sq' => 'Apartament me qira në Viti'],
                'description' => ['en' => 'Clean, well-maintained apartment for rent in Viti center. All modern amenities, close to shops and schools.', 'sq' => 'Apartament i pastër, i mirëmbajtur me qira në qendër të Vitisë. Të gjitha komoditet moderne, pranë dyqaneve dhe shkollave.'],
                'listing_type' => 'rent', 'price' => 200, 'city' => 'Viti', 'address' => 'Rruga Kryesore, Viti',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 65, 'year_built' => 2019, 'floors' => 1,
                'features' => ['Central Heating', 'Balcony', 'Furnished'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],

            // ─── Shtërpcë ───
            [
                'title' => ['en' => 'Ski Chalet near Brezovica in Shtërpcë', 'sq' => 'Çalet ski pranë Brezovicës në Shtërpcë'],
                'description' => ['en' => 'Cozy ski chalet near the Brezovica ski resort. Wooden interior, fireplace, mountain views, and perfect location for winter sports enthusiasts.', 'sq' => 'Çalet ski i ngrohtë pranë qendrës së skive të Brezovicës. Interier druri, oxhak, pamje malesh dhe vendndodhje perfekte për adhuruesit e sporteve dimërore.'],
                'listing_type' => 'sale', 'price' => 230000, 'city' => 'Shtërpcë', 'address' => 'Brezovicë, Shtërpcë',
                'bedrooms' => 4, 'bathrooms' => 2, 'area_sqm' => 180, 'year_built' => 2020, 'floors' => 2,
                'features' => ['Fireplace', 'Mountain View', 'Terrace', 'Garden', 'Parking', 'Furnished'],
                'is_featured' => true, 'property_type' => 'villa',
            ],

            // ─── Dragash ───
            [
                'title' => ['en' => 'Traditional House with Land in Dragash', 'sq' => 'Shtëpi tradicionale me tokë në Dragash'],
                'description' => ['en' => 'Traditional mountain house in the scenic Dragash region with large plot of land. Perfect for eco-tourism or sustainable farming projects.', 'sq' => 'Shtëpi tradicionale malesh në rajonin skenografik të Dragashit me parcelë të madhe toke. Perfekte për eko-turizëm ose projekte bujqësie të qëndrueshme.'],
                'listing_type' => 'sale', 'price' => 55000, 'city' => 'Dragash', 'address' => 'Fshati Brod, Dragash',
                'bedrooms' => 3, 'bathrooms' => 1, 'area_sqm' => 160, 'year_built' => 1980, 'floors' => 2,
                'features' => ['Garden', 'Mountain View', 'Fireplace', 'Storage Room'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Kllokot ───
            [
                'title' => ['en' => 'Apartment near Spa in Kllokot', 'sq' => 'Apartament pranë banjës termale në Kllokot'],
                'description' => ['en' => 'Small apartment near the famous Kllokot thermal spa. Ideal investment for short-term rentals to spa visitors.', 'sq' => 'Apartament i vogël pranë banjës termale të famshme të Kllokotit. Investim ideal për qira afatshkurtra për vizitorët e banjës.'],
                'listing_type' => 'sale', 'price' => 38000, 'city' => 'Kllokot', 'address' => 'Pranë Banjës, Kllokot',
                'bedrooms' => 1, 'bathrooms' => 1, 'area_sqm' => 45, 'year_built' => 2018, 'floors' => 1,
                'features' => ['Furnished', 'Central Heating'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],

            // ─── Graçanicë ───
            [
                'title' => ['en' => 'Residential Land in Graçanicë', 'sq' => 'Tokë rezidenciale në Graçanicë'],
                'description' => ['en' => 'Residential plot in a growing area of Graçanicë, just 10km from Prishtina. Utilities available on site.', 'sq' => 'Parcelë rezidenciale në zonë në rritje të Graçanicës, vetëm 10km nga Prishtina. Shërbimet e disponueshme në vend.'],
                'listing_type' => 'sale', 'price' => 40000, 'city' => 'Graçanicë', 'address' => 'Zona Rezidenciale, Graçanicë',
                'bedrooms' => 0, 'bathrooms' => 0, 'area_sqm' => 350, 'year_built' => null, 'floors' => 0,
                'features' => [],
                'is_featured' => false, 'property_type' => 'land',
            ],

            // ─── Junik ───
            [
                'title' => ['en' => 'Stone Tower House in Junik', 'sq' => 'Kullë gurit në Junik'],
                'description' => ['en' => 'Unique historic stone tower (kulla) in Junik, a protected cultural heritage site. Restored with modern amenities while preserving original architecture.', 'sq' => 'Kullë historike unike e gurit në Junik, vend i trashëgimisë kulturore të mbrojtur. E restauruar me komoditete moderne duke ruajtur arkitekturën origjinale.'],
                'listing_type' => 'sale', 'price' => 165000, 'city' => 'Junik', 'address' => 'Qendra Historike, Junik',
                'bedrooms' => 4, 'bathrooms' => 2, 'area_sqm' => 220, 'year_built' => 1850, 'floors' => 3,
                'features' => ['Mountain View', 'Fireplace', 'Garden', 'Storage Room'],
                'is_featured' => true, 'property_type' => 'house',
            ],

            // ─── Mamushë ───
            [
                'title' => ['en' => 'Agricultural Land in Mamushë', 'sq' => 'Tokë bujqësore në Mamushë'],
                'description' => ['en' => 'Fertile agricultural land in the Mamushë municipality. Suitable for farming, orchards, or vineyard development.', 'sq' => 'Tokë bujqësore pjellore në komunën e Mamushës. E përshtatshme për bujqësi, pemishte ose zhvillim vreshtash.'],
                'listing_type' => 'sale', 'price' => 22000, 'city' => 'Mamushë', 'address' => 'Zona Bujqësore, Mamushë',
                'bedrooms' => 0, 'bathrooms' => 0, 'area_sqm' => 800, 'year_built' => null, 'floors' => 0,
                'features' => [],
                'is_featured' => false, 'property_type' => 'land',
            ],

            // ─── Novobërdë ───
            [
                'title' => ['en' => 'Countryside Property near Novobërdë Fortress', 'sq' => 'Pronë fshatare pranë Kalasë së Novobërdës'],
                'description' => ['en' => 'Rustic property near the medieval Novobërdë Fortress. Includes a renovated house and large plot of land with panoramic views.', 'sq' => 'Pronë rustike pranë Kalasë mesjetare të Novobërdës. Përfshin shtëpi të renovuar dhe parcelë të madhe toke me pamje panoramike.'],
                'listing_type' => 'sale', 'price' => 48000, 'city' => 'Novobërdë', 'address' => 'Pranë Kalasë, Novobërdë',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 120, 'year_built' => 1990, 'floors' => 1,
                'features' => ['Garden', 'Mountain View', 'Storage Room', 'Parking'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Ranillug ───
            [
                'title' => ['en' => 'Small Farm Property in Ranillug', 'sq' => 'Pronë e vogël bujqësore në Ranillug'],
                'description' => ['en' => 'Small farm property with house and outbuildings in the peaceful Ranillug municipality. Ideal for organic farming or rural retreat.', 'sq' => 'Pronë e vogël bujqësore me shtëpi dhe ndërtesa ndihmëse në komunën e qetë të Ranillugut. Ideale për bujqësi organike ose strehim rural.'],
                'listing_type' => 'sale', 'price' => 28000, 'city' => 'Ranillug', 'address' => 'Zona Rurale, Ranillug',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 100, 'year_built' => 1985, 'floors' => 1,
                'features' => ['Garden', 'Storage Room', 'Parking'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Partesh ───
            [
                'title' => ['en' => 'Building Land in Partesh', 'sq' => 'Tokë ndërtimi në Partesh'],
                'description' => ['en' => 'Building land in Partesh with road access and utilities nearby. Suitable for single family home construction.', 'sq' => 'Tokë ndërtimi në Partesh me akses rrugor dhe shërbime afër. E përshtatshme për ndërtimin e shtëpisë familjare.'],
                'listing_type' => 'sale', 'price' => 18000, 'city' => 'Partesh', 'address' => 'Zona Rezidenciale, Partesh',
                'bedrooms' => 0, 'bathrooms' => 0, 'area_sqm' => 300, 'year_built' => null, 'floors' => 0,
                'features' => [],
                'is_featured' => false, 'property_type' => 'land',
            ],

            // ─── Leposaviq ───
            [
                'title' => ['en' => 'Affordable House in Leposaviq', 'sq' => 'Shtëpi e përballueshme në Leposaviq'],
                'description' => ['en' => 'Affordable house in Leposaviq with garden and outbuildings. Located in a quiet area with access to local amenities.', 'sq' => 'Shtëpi e përballueshme në Leposaviq me kopsht dhe ndërtesa ndihmëse. E vendosur në zonë të qetë me akses në shërbime lokale.'],
                'listing_type' => 'sale', 'price' => 32000, 'city' => 'Leposaviq', 'address' => 'Qendra, Leposaviq',
                'bedrooms' => 3, 'bathrooms' => 1, 'area_sqm' => 110, 'year_built' => 1992, 'floors' => 1,
                'features' => ['Garden', 'Parking', 'Storage Room'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Zubin Potok ───
            [
                'title' => ['en' => 'Lakefront Property in Zubin Potok', 'sq' => 'Pronë buzë liqenit në Zubin Potok'],
                'description' => ['en' => 'Scenic property near the Gazivoda Lake in Zubin Potok. Ideal for tourism development or peaceful lakeside living.', 'sq' => 'Pronë skenografike pranë Liqenit të Gazivodës në Zubin Potok. Ideale për zhvillim turistik ose jetesë të qetë buzë liqenit.'],
                'listing_type' => 'sale', 'price' => 45000, 'city' => 'Zubin Potok', 'address' => 'Pranë Liqenit, Zubin Potok',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 130, 'year_built' => 1998, 'floors' => 1,
                'features' => ['Garden', 'Parking', 'Mountain View'],
                'is_featured' => false, 'property_type' => 'house',
            ],

            // ─── Zveçan ───
            [
                'title' => ['en' => 'Residential Plot in Zveçan', 'sq' => 'Parcelë rezidenciale në Zveçan'],
                'description' => ['en' => 'Residential building plot in Zveçan with road access and utilities. Suitable for new home construction in a developing area.', 'sq' => 'Parcelë rezidenciale ndërtimi në Zveçan me akses rrugor dhe shërbime. E përshtatshme për ndërtim shtëpie të re në zonë në zhvillim.'],
                'listing_type' => 'sale', 'price' => 20000, 'city' => 'Zveçan', 'address' => 'Zona Rezidenciale, Zveçan',
                'bedrooms' => 0, 'bathrooms' => 0, 'area_sqm' => 450, 'year_built' => null, 'floors' => 0,
                'features' => [],
                'is_featured' => false, 'property_type' => 'land',
            ],

            // ─── Mitrovicë e Veriut (North Mitrovica) ───
            [
                'title' => ['en' => 'Apartment in North Mitrovica', 'sq' => 'Apartament në Mitrovicë të Veriut'],
                'description' => ['en' => 'Well-located apartment in the northern part of Mitrovica. Close to local shops, schools, and the Ibar River promenade.', 'sq' => 'Apartament i vendosur mirë në pjesën veriore të Mitrovicës. Pranë dyqaneve lokale, shkollave dhe shëtitores së Lumit Ibar.'],
                'listing_type' => 'sale', 'price' => 42000, 'city' => 'Mitrovicë e Veriut', 'address' => 'Qendra, Mitrovicë e Veriut',
                'bedrooms' => 2, 'bathrooms' => 1, 'area_sqm' => 65, 'year_built' => 2010, 'floors' => 1,
                'features' => ['Central Heating', 'Balcony'],
                'is_featured' => false, 'property_type' => 'apartment',
            ],
        ];

        foreach ($properties as $index => $data) {
            $typeSlug = $data['property_type'];
            unset($data['property_type']);

            $type = PropertyType::where('slug', $typeSlug)->first();
            $agent = $agents[array_rand($agents)];

            $property = Property::updateOrCreate(
                ['slug' => Str::slug($data['title']['en']) . '-' . ($index + 1)],
                array_merge($data, [
                    'user_id' => $agent->id,
                    'property_type_id' => $type->id,
                    'slug' => Str::slug($data['title']['en']) . '-' . ($index + 1),
                    'country' => 'Kosovo',
                    'currency' => 'EUR',
                    'status' => 'active',
                    'views' => rand(50, 500),
                ])
            );

            // Add 3 images per property
            for ($i = 0; $i < 3; $i++) {
                PropertyImage::updateOrCreate(
                    ['property_id' => $property->id, 'sort_order' => $i],
                    [
                        'image_path' => $images[($index * 3 + $i) % count($images)],
                        'is_primary' => $i === 0,
                    ]
                );
            }
        }

        $this->command->info('✅  Seeded ' . count($properties) . ' properties across all ' . collect($properties)->pluck('city')->unique()->count() . ' Kosovo municipalities.');
    }
}
