<?php
/*
 * This file is part of the HessianPHP package.
 * (c) 2004-2011 Manuel Gómez
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Represents a stream of bytes used for reading
 * It doesn't use any of the string length functions typically used
 * for files because if can cause problems with encodings different than latin1
 * @author vsayajin
 */
class HessianStream{
	public $pos = 0;
	public $len;
	public $bytes = array();
	public $str = '';
	
	function __construct($data = null, $length = null){
		if($data)
			$this->setStream($data, $length);
	}
	
	function setStream($data, $length = null){
		//$this->bytes = str_split($data);
		$this->str = $data;
		$this->len = strlen($this->str);
		$this->pos = 0;
	}
	
	public function peek($count = 1, $pos = null){
		if($pos == null)
			$pos = $this->pos;
		
		$portion = substr($this->str, $pos, $count);
		return $portion;
	}

	public function read($count=1){
		if($count == 0)
			return;
		
		$portion = substr($this->str, $this->pos, $count);
		$read = strlen($portion);
		$this->pos += $count;
		if($read < $count) {
			if($this->pos == 0)
				throw new Exception('Empty stream received!');
			else
				throw new Exception('read past end of stream: '.$this->pos);
		}
		return $portion;
	}
	
	public function readAll(){
		$this->pos = $this->len;
		return $this->str;		
	}

	public function write($data){
		$bytes = $data;
		$this->len += strlen($bytes);
		$this->str = $this->str . $bytes;
	}
 
	public function flush(){}
	
	public function getData(){
		return $this->str;
	}
	
	public function close(){		
	}
}


