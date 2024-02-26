<?php

namespace Modules\Admin\App\Traits;

use Modules\Admin\App\Services\LanguageService;

trait StoreTranslationRequestValidation
{
    public function getRules(array $keys): array
    {
        $languages = (new LanguageService())->getLanguages();
        $rules = [];
        foreach ($keys as $key) {
            $rules[$key] = ['array', 'size:'.$languages->count()];
            foreach ($languages as $language) {
                $rules[$key.'.'.$language->code] = ['required', 'string', 'max:255'];
            }
        }

        return $rules;
    }
}
