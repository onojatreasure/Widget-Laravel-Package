<?php

namespace Tests\Feature;

use Treasure\Widget\Widget;
use Orchestra\Testbench\TestCase;
use Treasure\Widget\WidgetServiceProvider;

class WidgetTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            WidgetServiceProvider::class
        ];
    }

    /** @test */
    public function it_compiles_the_widget_blade_directive()
    {
        $string = "@widget('Treasure\Widget\Tests\TestWidget')";
        $expected = "<?= resolve('Treasure\Widget\Tests\TestWidget'); ?>";
        
        $compiled = resolve('blade.compiler')->compileString($string);

        $this->assertEquals($expected, $compiled);
    }

    /** @test */
    function it_chooses_a_default_view_name_based_on_the_class()
    {
        $widget = new TestWidget();

        $this->assertEquals('test-widget', $widget->viewName());
    }

    /** @test */
    function all_public_properties_are_available_to_the_view()
    {
        
        $this->assertStringContainsString('Test Widget', TestWidget::render());
    }

    /** @test */
    function all_public_methods_are_available_to_the_view()
    {
        $view = TestWidget::render();

        $this->assertStringContainsString('item 1', $view);
        $this->assertStringContainsString('item 2', $view);
    }

    /** @test */
    public function it_renders_itself_when_converted_to_a_string()
    {
        $this->assertStringContainsString('Test Widget', new TestWidget);
    }
}


class TestWidget extends Widget 
{
    public $title = 'Test Widget';

    public function items()
    {
        return ['item 1', 'item 2'];
    }

    public function view()
    {
        return view()->file(__DIR__.'/stubs/test-widget.blade.php');
    }
}



?>