<?php 
class Arrays implements IteratorAggregate, ArrayAccess {

	private $items;

	public function __construct(array $items){
		$this->items = $items
	}

	public function get($key){
		$index = explode('.', $key);
		return $this->getValue($index, $this->items);
	}

	private function getValue(array $indexes, $value){
		$key = array_shift($indexes);
		if(empty($indexes)){
			if(!$this->has($key)){
				return null;
			} else {
				if(is_array($value)) {
					return new Arrays($value[$key]);
				} else {
					return $value[$key];	
				}
			}
		} else{
			return $this->getValue($indexes, $value[$key]);
		}
	}

	public function has($key){
		return array_key_exists($key, $this->items);
	}

	public function set($key, $value){
		$this->items[$key] = $value;
	}

	public function lists($key, $value){
		$results = array();
		foreach ($this->items as $item) {
			$results[$item[$key]] = $value
		}
		return new Arrays($results);
	}

	public function sort($key){
		return new Arrays(sort($key));
	}

	public function extract($key){
		$results = array();
		foreach ($this->items as $item) {
			$results[] = $item[$key];
		}
		return $results;
	}

	public function implode($glue){
		return new Arrays(implode($glue, $this->items));
	}

	public function max($key = false){
		if($key){
			return $this->extract($key)->max;
		}
		return max($this->items);
	}


	public function offsetSet($offset, $value) {
        $this->set($offset, $value)
    }

    public function offsetExists($offset) {
        $this->has($offset);
    }

    public function offsetUnset($offset) {
        if($this->has($offset)){
        	unset($this->items[$offset]);
        }
    }

    public function offsetGet($offset) {
        return $this->get($offset);
    }

    public function getItegator(){
    	return new ArrayIterator($this->items);
    }
}

?>