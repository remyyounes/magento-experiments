<?php

class Makina_Accordionnavigation_Helper_Category extends Mage_Catalog_Helper_Category
{
	public function getAllCategories($sorted=false, $asCollection=false, $toLoad=true)
	{
		$parent = Mage::app()->getStore()->getRootCategoryId();
		$cacheKey = sprintf('%d-%d-%d-%d', $parent, $sorted, $asCollection, $toLoad);
		if(isset($this->_storeCategories[$cacheKey])){
			return $this->_storeCategories[$cacheKey];
		}
		$categoryDepth = 0;
		$category = Mage::getModel('catalog/category');
		$storeCategories = $category->getCategories($parent, $categoryDepth, $sorted, $asCollection, $toLoad);
		
		$this->_storeCategories[$cacheKey] = $storeCategories;
		return $storeCategories;

	}
}