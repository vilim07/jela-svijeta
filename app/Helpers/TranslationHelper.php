<?php

namespace App\Helpers;

use App\Models\Lang;
use Faker\Factory as FakerFactory;


class TranslationHelper
{
    /**
     * Generate translations for a specific attribute.
     *
     * @param array  $attributes
     *
     * @return array
     */


    public static function generateTranslations(array $attributes): array
    {

        $locales = Lang::all()->pluck('locale')->toArray();
        $translations = [];



        foreach ($attributes as $attribute) {


            if (isset($attribute[3]) && is_numeric($attribute[3])){
                $seed = $attribute[3];

            } else if (isset($attribute[3]) && $attribute[3]) {
                $seed = mt_rand();
            }

            foreach ($locales as $locale) {

                $faker;
                $faker = FakerFactory::create();
                $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));
                $faker->addProvider(new \Bezhanov\Faker\Provider\Food($faker));

                //FakerRestaraunt translations vary and sometimes three languages won't have translations for the same item.
                //This is how it would be done if it worked correctly.
/*                 if ($locale === 'en') {
                    $faker = FakerFactory::create();
                    $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));
                } elseif ($locale === 'de') {
                    $faker = FakerFactory::create('de_DE');
                    $faker->addProvider(new \FakerRestaurant\Provider\de_DE\Restaurant($faker));
                } elseif ($locale === 'fr') {
                    $faker = FakerFactory::create('fr_FR');
                    $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));
                } */

                if (isset($attribute[3]) && $attribute[3]) {
                    $faker->seed($seed);
                }

                $params = [];

                if (isset($attribute[2])) {
                    $params = $attribute[2];
                }

                $value = call_user_func_array([$faker, $attribute[1]], $params);

                //This is added to show translations work since the faker library doesnt support tranlsations fully.
                if ($locale !== 'en') {
                    $value = $value . ' (' . $locale . ')';
                }

                $translations[$locale][$attribute[0]] = $value;
            }
        }



        return $translations;
    }

}