<?php

/**
 * @file 
 * Contains \Drupal\yandex_weather\Plugin\Block\api_yandex_weather
*/

namespace Drupal\yandex_weather\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a yandex_weather
 * 
 * @Block(
 * id = "yandex_weather",
 * admin_label = @Translation("API Yandex weather"), 
 * category = @Translation("Block for import information yandex weather")
 * )
*/

class api_yandex_weather extends BlockBase{
  /**
   * {@inheritdoc}
   */
  public function build(){
	  
	  return array(
		'#theme' => 'block_ya_weather',
		'#result' => $this->result(),
	  );
  }
 


/**
 * Provides resault information
*/   
  private function result(){
	$client = \Drupal::httpClient();
	
	$url = "https://api.weather.yandex.ru/v2/informers?lat=45.043317&lon=41.969110";
	$response = $client->get($url, array('headers' => array('X-Yandex-API-Key' => 'c3014e2d-656e-4389-8ea5-6e5bb2bc5118')));
	$body = $response->getBody()->getContents();
	$data = json_decode($body , 1);	
	    
	return $data;
  }  
	
}  

