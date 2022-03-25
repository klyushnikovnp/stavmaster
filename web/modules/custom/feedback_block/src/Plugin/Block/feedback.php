<?php

/**
 * @file 
 * Contains \Drupal\feedback_block\Plugin\Block\feedback
*/

namespace Drupal\feedback_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a feedback_block
 * 
 * @Block(
 * id = "feedback_block",
 * admin_label = @Translation("Feedback Block"),
 * category = @Translation("Block for context feedback message on the product pages")
 * )
*/

class feedback extends BlockBase{
  /**
   * {@inheritdoc}
   */
  public function build(){
	  
	  return array(
		'#theme' => 'block_feedback_product',
		'#result' => $this->result(),
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
 * Get list feedback
 * $id - input $id services
 * $return list feedback
*/  
  private function getListFeedback($id){
	$query = \Drupal::entityQuery('node');
	$query->condition('type', 'feedback');
	$query->condition('field_category', $id);
	$query->range(0, 5);	
	$query->condition('status', 1); 
	$nids = $query->execute();

	$feedback = \Drupal\node\Entity\Node::loadMultiple($nids);
	
	return $feedback;  
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
	//get list feedback
	$result = $this->getListFeedback($id_services);	
	
	return $result;
  }  
	
}  