<?php

/**
 * @file 
 * Contains \Drupal\articles_block\Plugin\Block\articles
*/

namespace Drupal\articles_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a articles_block
 * 
 * @Block(
 * id = "articles_block",
 * admin_label = @Translation("Articles Block"),
 * category = @Translation("Block for context articles on the product pages")
 * )
*/

class articles extends BlockBase{
  /**
   * {@inheritdoc}
   */
  public function build(){
	  
	  $items = $this->informat();
	  kint($items);
	  	  
	  return array(
		'#theme' => 'block_articles_product',
		'#items' => "333",
	  );
  }   
  
  
  private function informat(){
	$id_page = \Drupal::routeMatch()->getParameter('node');
	kint($id_page->id());
	$id =$id_page->id();
	
	$query = \Drupal::entityQuery('node');
	$query->condition('type', 'services');
	$query->condition('nid', $id);
	$query->condition('status', 1); 
	$id_services = $query->execute();
	
	
	/*$query = \Drupal::entityQuery('node');
	$query->condition('type', 'article');
	$query->condition('status', 1); 
	$nids = $query->execute();*/
	
	$nodes = \Drupal\node\Entity\Node::loadMultiple($id_services);
	$a = $nodes[7]->get('field_category_service')->getValue();
	//$a = $nodes->get();
	//return $nodes; 
	return $a;

  }
  
}