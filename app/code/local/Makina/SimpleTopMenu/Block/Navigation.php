<?php

class Makina_SimpleTopMenu_Block_Navigation extends Mage_Catalog_Block_Navigation
{
    const CUSTOM_BLOCK_TEMPLATE = "Makina_SimpleTopMenu_%d";
    private $_productsCount = null;

    public function drawCustomMenuItem($category, $level = 0, $last = false)
    {
        if (!$category->getIsActive()) return '';
        $html = array();
        $id = $category->getId();
        $name = $this->escapeHtml($category->getName());
        // --- Sub Categories ---
        $activeChildren = $this->_getActiveChildren($category, $level);
        // --- class for active category ---
        $active = ''; if ($this->isCategoryActive($category)) $active = ' act';
        $html[] = '<li id="cat_' . $id . '" class="menu' . $active . '"  data-level="'.$level.'">';
        $html[] = '<a href="'.$this->getCategoryUrl($category).'">'.$name.'</a>';

        if (count($activeChildren)) {
            if($level === 0) $html[] = "<div class='subcontainer'>";
            $html[] = '<ul>';
            foreach ($activeChildren as $child) {
                $html[] = $this->drawCustomMenuItem($child, $level+1);
                Mage::log($child->getName());
            }
            $html[] = '</ul>';
            if($level === 0) $html[] = "</div>";
        }

        $html[] = '</li>';

        $html = implode("\n", $html);

        return $html;
    }

    protected function _getActiveChildren($parent, $level)
    {
        $activeChildren = array();
        // --- check level ---
        $maxLevel = (int)Mage::getStoreConfig('custom_menu/general/max_level');
        if ($maxLevel > 0 && ($level >= ($maxLevel - 1)))return $activeChildren;
        // --- / check level ---
        if (Mage::helper('catalog/category_flat')->isEnabled())
        {
            $children = $parent->getChildrenNodes();
            $childrenCount = count($children);
        }
        else
        {
            $children = $parent->getChildren();
            $childrenCount = $children->count();
        }
        $hasChildren = $children && $childrenCount;
        if ($hasChildren)
        {
            foreach ($children as $child)
            {
                if ($this->_isCategoryDisplayed($child))
                {
                    array_push($activeChildren, $child);
                }
            }
        }
        return $activeChildren;
    }


    private function _isCategoryDisplayed(&$child)
    {
        if (!$child->getIsActive()) return false;
        // === check products count ===
        // --- get collection info ---
        if (!Mage::getStoreConfig('custom_menu/general/display_empty_categories'))
        {
            $data = $this->_getProductsCountData();
            // --- check by id ---
            $id = $child->getId();
            #Mage::log($id); Mage::log($data);
            if (!isset($data[$id]) || !$data[$id]['product_count']) return false;
        }
        // === / check products count ===
        return true;
    }


    private function _getProductsCountData()
    {
        if (is_null($this->_productsCount))
        {
            $collection = Mage::getModel('catalog/category')->getCollection();
            $storeId = Mage::app()->getStore()->getId();
            /* @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection */
            $collection->addAttributeToSelect('name')
                ->addAttributeToSelect('is_active')
                ->setProductStoreId($storeId)
                ->setLoadProductCount(true)
                ->setStoreId($storeId);
            $productsCount = array();
            foreach($collection as $cat)
            {
                $productsCount[$cat->getId()] = array(
                    'name' => $cat->getName(),
                    'product_count' => $cat->getProductCount(),
                );
            }
            Mage::log($productsCount);
            $this->_productsCount = $productsCount;
        }
        return $this->_productsCount;
    }

}

?>