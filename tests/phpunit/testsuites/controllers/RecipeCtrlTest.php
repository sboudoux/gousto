<?php

namespace Test\Phpunit;

class RecipeCtrlTest extends \Test\Phpunit\UnitTestCase
{

    public function testNotfoundActionThrowsException()
    {
        $this->setUp();
        $oRecipeCtrl = new \App\Controllers\RecipeController();

        //$this->expectExceptionObject()
        $this->expectException('\App\Controllers\HttpExceptions\Http404Exception');
        $oRecipeCtrl->notfoundAction();

    }

    public function testNotfoundActionReturnsNull()
    {
        $this->setUp();
        $oRecipeCtrl = new \App\Controllers\RecipeController();

        //$this->expectExceptionObject()
        $this->expectException('\App\Controllers\HttpExceptions\Http404Exception');
        $vResult = null;
        $vResult = $oRecipeCtrl->notfoundAction();

        $this->assertNull($vResult);
    }

    public function testFindRecipeParameterStringThrowsException()
    {
        $this->setUp();

        $oRecipeCtrl = new \App\Controllers\RecipeController();

        //invalid recipe ID >> failure
        $this->expectException('\App\Controllers\HttpExceptions\Http400Exception');
        $oRecipeCtrl->findRecipeAction('recipe34');
    }

    public function testFindRecipeParameterNegativeIntThrowsException()
    {
        $this->setUp();

        $oRecipeCtrl = new \App\Controllers\RecipeController();

        //invalid recipe ID >> failure
        $this->expectException('BadMethodCallException');
        $iId = -2;
        $oRecipeCtrl->findRecipeAction($iId);
    }

    public function testFindRecipeParameterFloatThrowsException()
    {
        $this->setUp();

        $oRecipeCtrl = new \App\Controllers\RecipeController();

        //invalid recipe ID >> failure
        $this->expectException('BadMethodCallException');
        $oRecipeCtrl->findRecipeAction(1.5);
    }


    public function testFindRecipeWronghttpMethod()
    {
        $this->setUp();
        $this->getDi()->getRequest()->setHttpMethodParameterOverride('PATCH');

        $oRecipeCtrl = new \App\Controllers\RecipeController();

        //no recipe ID >> failure
        $this->expectException('BadMethodCallException');
        $oRecipeCtrl->findRecipeAction(1);
    }

}