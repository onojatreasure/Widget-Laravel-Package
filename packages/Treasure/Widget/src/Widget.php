<?php

namespace Treasure\Widget;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Illuminate\Support\Str;

abstract class Widget
{
    /**
     * Load the view with the necessary data.
     *
     * @return \Illuminate\View\View
     */
    public function loadView()
    {
        return $this->view()->with($this->buildViewData());
    }

    /**
     * Load the view for the widget.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $name = Str::kebab(class_basename($this));

        return view("widgets.{$name}");
    }

    /**
     * Build the view data.
     *
     * @return array
     * @throws \ReflectionException
     */
    protected function buildViewData()
    {
        $viewData = [];

        foreach ((new ReflectionClass($this))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $viewData[$property->getName()] = $property->getValue($this);
        }

        foreach ((new ReflectionClass($this))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (! in_array($name = $method->getName(), ['loadView', 'view'])) {
                $viewData[$name] = $this->$name();
            }
        }

        return $viewData;
    }
}