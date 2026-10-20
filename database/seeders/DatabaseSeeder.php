<?php

namespace Database\Seeders;

use App\Enums\Color;
use App\Enums\PlaceKind;
use App\Models\Item;
use App\Models\Place;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $hall = Place::create(['name' => 'Hall des Guichets Central', 'kind' => PlaceKind::Hall]);
        $quai1 = Place::create(['name' => 'Quai 1 bis', 'kind' => PlaceKind::Platform]);
        $quai2 = Place::create(['name' => 'Quai 4 Est', 'kind' => PlaceKind::Platform]);
        $train = Place::create(['name' => 'Rame Thalys Bruxelles-Amsterdam', 'kind' => PlaceKind::Train]);


        $tags = collect([
            Tag::create(['name' => 'Urgent']),
            Tag::create(['name' => 'Fragile']),
            Tag::create(['name' => 'Électronique']),
            Tag::create(['name' => 'Vêtement']),
            Tag::create(['name' => 'Enfant']),
            Tag::create(['name' => 'Loisir']),
            Tag::create(['name' => 'Nourriture']),
            Tag::create(['name' => 'Bizarre']),
        ]);

        $itemsData = [
            [
                'place' => $hall,
                'name' => 'Dentier lumineux à LED',
                'description' => 'Dentier complet clignotant en bleu, oublié sur un banc en attendant le billet.',
                'color' => Color::White,
                'found_on' => '2026-10-02',
                'returned_at' => null,
                'tags' => ['Bizarre', 'Urgent'],
            ],
            [
                'place' => $quai1,
                'name' => 'Monocycle de jongleur',
                'description' => 'Monocycle rouge un peu rouillé, pneu légèrement dégonflé.',
                'color' => Color::Red,
                'found_on' => '2026-10-04',
                'returned_at' => null,
                'tags' => ['Loisir'],
            ],
            [
                'place' => $train,
                'name' => 'Kouign-amann tiède',
                'description' => 'Dans une boîte en fer estampillée "Bretagne", encore un peu de beurre sur les bords.',
                'color' => Color::Brown,
                'found_on' => '2026-10-05',
                'returned_at' => null,
                'tags' => ['Nourriture', 'Fragile'],
            ],
            [
                'place' => $quai2,
                'name' => 'Album photo de chats spationautes',
                'description' => 'Photos polaroid de félins portant des casques de cosmonaute faits maison.',
                'color' => Color::Multicolor,
                'found_on' => '2026-10-06',
                'returned_at' => null,
                'tags' => ['Bizarre'],
            ],
            [
                'place' => $hall,
                'name' => 'Ukulélé en bois de rose',
                'description' => 'Il manque la corde de mi, autocollant "Free Hugs" collé au dos.',
                'color' => Color::Brown,
                'found_on' => '2026-10-07',
                'returned_at' => null,
                'tags' => ['Fragile', 'Loisir'],
            ],
            [
                'place' => $train,
                'name' => 'Tuba de compétition fluo',
                'description' => 'Tuba vert et orange, autocollant d’un club de plongée de Charleroi.',
                'color' => Color::Green,
                'found_on' => '2026-10-08',
                'returned_at' => null,
                'tags' => ['Loisir'],
            ],
            [
                'place' => $quai1,
                'name' => 'Gant de boxe pailleté rose',
                'description' => 'Taille enfant, main gauche uniquement, sent légèrement la fraise des bois.',
                'color' => Color::Pink,
                'found_on' => '2026-10-09',
                'returned_at' => null,
                'tags' => ['Enfant'],
            ],
            [
                'place' => $hall,
                'name' => 'Thermos de soupe à l’oignon',
                'description' => 'Fait un bruit suspect et gargouillant quand on l’agite près de l’oreille.',
                'color' => Color::Grey,
                'found_on' => '2026-10-10',
                'returned_at' => null,
                'tags' => ['Nourriture'],
            ],
            [
                'place' => $train,
                'name' => 'Kilt écossais de secours',
                'description' => 'Taille L, fourni avec une épingle à nourrice géante en plastique.',
                'color' => Color::Red,
                'found_on' => '2026-10-11',
                'returned_at' => null,
                'tags' => ['Vêtement'],
            ],
            [
                'place' => $quai2,
                'name' => 'Trottinette pour hamster',
                'description' => 'En plastique rose, roues qui grincent bruyamment.',
                'color' => Color::Pink,
                'found_on' => '2026-10-12',
                'returned_at' => null,
                'tags' => ['Enfant'],
            ],
            [
                'place' => $hall,
                'name' => 'Livre de cuisine vegan pour carnivores',
                'description' => 'Dédicacé par l’auteur, pages de recettes de faux-steaks cornées.',
                'color' => Color::Yellow,
                'found_on' => '2026-10-13',
                'returned_at' => null,
                'tags' => [],
            ],
            [
                'place' => $quai1,
                'name' => 'Oreiller ergonomique à mémoire de forme',
                'description' => 'Porte des traces évidentes de bave et sent le baume du tigre.',
                'color' => Color::White,
                'found_on' => '2026-10-14',
                'returned_at' => null,
                'tags' => [],
            ],
            // --- Les 3 objets restitués ---
            [
                'place' => $train,
                'name' => 'Casque anti-bruit spatial',
                'description' => 'Casque argenté diffusant de la musique zen en boucle dans le compartiment.',
                'color' => Color::Grey,
                'found_on' => '2026-10-03',
                'returned_at' => '2026-10-05', 
                'tags' => ['Électronique', 'Urgent'],
            ],
            [
                'place' => $quai2,
                'name' => 'Parapluie arc-en-ciel géant',
                'description' => 'Parapluie de golf à 16 baleines, capable d’abriter une petite famille.',
                'color' => Color::Multicolor,
                'found_on' => '2026-10-05',
                'returned_at' => '2026-10-08',
                'tags' => ['Fragile'],
            ],
            [
                'place' => $hall,
                'name' => 'Valisette de magicien débutant',
                'description' => 'Contient un faux pouce en plastique, un jeu de cartes corrompu et une baguette magique en bois.',
                'color' => Color::Black,
                'found_on' => '2026-10-10',
                'returned_at' => '2026-10-12',
                'tags' => ['Loisir', 'Enfant'],
            ],
        ];

        foreach ($itemsData as $data) {
            $item = Item::create([
                'place_id' => $data['place']->id,
                'name' => $data['name'],
                'description' => $data['description'],
                'color' => $data['color'],
                'found_on' => $data['found_on'],
                'returned_at' => $data['returned_at'],
            ]);

            if (!empty($data['tags'])) {
                $tagIds = $tags->whereIn('name', $data['tags'])->pluck('id');
                $item->tags()->attach($tagIds);
            }
        }
    }
}
