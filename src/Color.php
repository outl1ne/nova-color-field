<?php

namespace Outl1ne\NovaColorField;

use Exception;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class Color extends Field
{
    use SupportsDependentFields;

    public $component = 'color-field';

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        $this->twitter();
        $this->autoHidePicker();
        $this->saveAs('hex');
        $this->displayAs('hex');
        $this->nullable();
    }

    public function autoHidePicker(bool $shouldAutoHide = true)
    {
        return $this->withMeta(['autoHidePicker' => $shouldAutoHide]);
    }

    public function pickerType(string $type)
    {
        return $this->withMeta(['pickerType' => $type]);
    }

    public function palette(array $palette)
    {
        return $this->withMeta(['palette' => $palette]);
    }

    public function chrome()
    {
        return $this->pickerType('chrome');
    }

    public function twitter()
    {
        return $this->pickerType('twitter');
    }

    public function compactTheme()
    {
        return $this->pickerType('compact');
    }

    public function grayscale()
    {
        return $this->pickerType('grayscale');
    }

    public function material()
    {
        return $this->pickerType('material');
    }

    public function photoshop()
    {
        return $this->pickerType('photoshop');
    }

    public function sketch()
    {
        return $this->pickerType('sketch');
    }

    public function slider()
    {
        return $this->pickerType('slider');
    }

    public function swatches()
    {
        return $this->pickerType('swatches');
    }

    public function hidePicker()
    {
        return $this->pickerType('none');
    }

    public function saveAs($saveAs = 'hex')
    {
        if (! in_array($saveAs, ['rgb', 'rgba', 'hex', 'hex8', 'hsl'])) {
            throw new Exception("Invalid saveAs option provided [{$saveAs}].");
        }
        $saveAs = ($saveAs === 'rgba') ? 'rgb' : $saveAs;

        return $this->withMeta(['saveAs' => $saveAs]);
    }

    public function displayAs($displayAs = 'hex')
    {
        if (! in_array($displayAs, ['rgb', 'rgba', 'hex', 'hex8', 'hsl'])) {
            throw new Exception("Invalid displayAs option provided [{$displayAs}].");
        }
        $displayAs = ($displayAs === 'rgba') ? 'rgb' : $displayAs;

        return $this->withMeta(['displayAs' => $displayAs]);
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            // Try to turn into array
            $value = $request[$requestAttribute];
            $arrayValue = json_decode($value, true);

            if (! empty($arrayValue)) {
                $value = $arrayValue;
            }

            $model->{$attribute} = $this->isNullValue($value) ? null : $value;
        }
    }
}
