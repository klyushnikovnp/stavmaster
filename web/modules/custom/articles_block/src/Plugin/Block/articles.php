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
	  
	  //kint($items);
	  	  
	  return array(
		'#theme' => 'block_articles_product',
		'#result' => $this->result(),
		'#article_list' => '',
	  );
  }   
  
/**
 * Get ID node
 * $id - ID node 
 * 
*/  
  private function getIdPage(){
	$id_page = \Drupal::routeMatch()->getParameter('node');
	$id = $id_page->id();
	return $id;	
  }
  
/**
 * Get list articles
 * $id - input $id services
 * $return list articles
*/  
  private function getListActicles($id){
	$query = \Drupal::entityQuery('node');
	$query->condition('type', 'article');
	$query->condition('field_tags', $id);
	$query->condition('status', 1); 
	$nids = $query->execute();

	$articles = \Drupal\node\Entity\Node::loadMultiple($nids);
	
	return $articles;  
	}
  
/**
 * Provides resault information
*/   
  private function result(){
	//get id node
	$id = $this->getIdPage();
	
	$query = \Drupal::entityQuery('node');
	$query->condition('type', 'services');
	$query->condition('nid', $id);
	$query->condition('status', 1); 
	$result_services = $query->execute();
	
	$nodes = \Drupal\node\Entity\Node::loadMultiple($result_services);
	$services = $nodes[$id]->get('field_category_service')->getValue();
	//ID page services
	$id_services = $services[0]['target_id'];
	//get list articles
	$result = $this->getListActicles($id_services);
	
	return $result;

  }
  
}