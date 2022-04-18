<?php

/**
 * @file 
 * Contains \Drupal\gallery_block\Plugin\Block\gallery
*/

namespace Drupal\gallery_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;

/**
 * Provides a gallery_block
 * 
 * @Block(
 * id = "gallery_block",
 * admin_label = @Translation("Gallery Block"),
 * category = @Translation("Block for context photos on the product pages")
 * )
*/

class gallery extends BlockBase{
  /**
   * {@inheritdoc}
   */
  public function build(){
	  
	  return array(
		'#theme' => 'block_gallery_product',
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
 * Get list photos
 * $id - input $id services
 * $return list photos
*/  
  private function getListphotos($id){
	$query = \Drupal::entityQuery('node');
	$query->condition('type', 'photogallery');
	$query->condition('field_category', $id);
	$query->condition('status', 1); 
	$nids = $query->execute();
	
	$photos = \Drupal\node\Entity\Node::loadMultiple($nids);
	
	return $photos;  
	}  
  
/**
 * Get pagargaph
 * $pid - input $id pagargaph
 * $return object pagargaph
*/  
  private function getParagraph($pid){
		//$pid = $arr['target_id'];
		$query = \Drupal::entityQuery('paragraph');
		$query->condition('type', 'photogallery');
		$query->condition('id', $pid);
		$output = $query->execute();	
		$paragraph = Paragraph::loadMultiple($output);	

	return $paragraph;  
	}  
  
  
/**
 * Get IMG
 * $mid - input $id image
 * $return url image
*/  
  private function getIMG($mid){
	  
		$media = Media::load($mid);
		$fid = $media->field_media_image_1->target_id;
		$file = File::load($fid);
		$url = $file->getFileUri();
		$img = \Drupal::service('file_system')->realpath($url);
		$var = substr($img, 44);

	return $var;   
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
	//get list photos
	$id_gallery = $this->getListphotos($id_services);
	foreach($id_gallery as $key=>$value){
		//get list paragraphs
			$arr_paragraphs = $value->get('field_photo')->getValue();
		}	 	 
	if(!is_null(@$arr_paragraphs)){		
		foreach($arr_paragraphs as $paragraph){
			$pid = $this->getParagraph($paragraph['target_id']);
			foreach($pid as $k=>$v){
				$mid = $v->get('field_photo')->target_id;
				if(!is_null($mid)){
					$url = $this->getIMG($mid);
					$result[$k]['image'] = $url;
				}
			}
		}
	}	

	return @$result;

  }  
}  

