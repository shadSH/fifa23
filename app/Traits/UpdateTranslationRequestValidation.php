<?php

namespace Modules\Admin\App\Traits;

use Modules\Admin\App\Services\LanguageService;

trait UpdateTranslationRequestValidation
{
    public function getRules(array $keys): array
    {
        $languages = (new LanguageService())->getLanguages();
        $rules = [];
        foreach ($keys as $key) {
            $rules[$key] = ['array'];
            foreach ($languages as $language) {
                $rules[$key.'.'.$language->code] = ['sometimes', 'required', 'string'];
            }
        }

        return $rules;
    }
}
