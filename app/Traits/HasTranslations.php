<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Spatie\Translatable\Events\TranslationHasBeenSetEvent;
use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait HasTranslations
{
    use BaseHasTranslations;

    public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, \App::getLocale());
        }

        return $attributes;
    }

    public function setTranslation(string $key, string $locale, $value): self
    {
        $this->guardAgainstNonTranslatableAttribute($key);

        $translations = $this->getTranslations($key);

        $oldValue = $translations[$locale] ?? '';

        if ($this->hasSetMutator($key)) {
            $method = 'set'.Str::studly($key).'Attribute';

            $this->{$method}($value, $locale);

            $value = $this->attributes[$key];
        }

        $translations[$locale] = $value;

        $this->attributes[$key] = json_encode($translations, JSON_UNESCAPED_UNICODE);

        event(new TranslationHasBeenSetEvent($this, $key, $locale, $oldValue, $value));

        return $this;
    }
}
