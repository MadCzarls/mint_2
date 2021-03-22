<?php

declare(strict_types=1);

namespace App\Translator;

use Sonata\AdminBundle\Translator\LabelTranslatorStrategyInterface;

class ProjectLabelTranslatorStrategy implements LabelTranslatorStrategyInterface
{
    public function getLabel($label, $context = '', $type = ''): string
    {
        $label = str_replace('.', '_', $label);

        return sprintf('%s_%s', $type, preg_replace('~(?<=\\w)([A-Z])~', ucfirst('$1'), $label));
    }
}
