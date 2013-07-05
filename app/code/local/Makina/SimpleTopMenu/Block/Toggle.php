<?php

class Makina_SimpleTopMenu_Block_Toggle extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        if(!Mage::getStoreConfig('simpletop_menu/general/enabled')) return;
        $layout = $this->getLayout();
        $topnav = $layout->getBlock('catalog.topnav');
        if(is_object($topnav))
        {
            $topnav->setTemplate('makina/simpletopmenu/top.phtml');
            $head = $layout->getBlock('head');
            $head->addItem("skin_css", "css/makina/simpletopmenu/simpletopmenu.css");
        }
    }
}