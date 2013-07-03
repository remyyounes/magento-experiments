<?php

if (!Mage::getStoreConfig('simpletop_menu/general/enabled') )
{
    class Makina_SimpleTopMenu_Block_Topmenu extends Mage_Page_Block_Html_Topmenu
    {
    }
}else{
    class Makina_SimpleTopMenu_Block_Topmenu extends Makina_SimpleTopMenu_Block_Navigation
    {
    }
}

?>