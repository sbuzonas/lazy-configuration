<?php

/**
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 *    Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 * 
 *    Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 * 
 *    Neither the name of FancyGuy Technologies nor the names of its
 *    contributors may be used to endorse or promote products derived from this
 *    software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * Copyright © 2013, FancyGuy Technologies
 * All rights reserved.
 */

namespace FancyGuy\Component\LazyConfiguration\Collection;

use FancyGuy\Component\LazyConfiguration\Entity\Entity;
use FancyGuy\Component\LazyConfiguration\Exception\MissingKeyException;

/**
 * Description of ConfigurationCollection
 *
 * @author Steve Buzonas <steve@fancyguy.com>
 */
class ArrayCollection implements CollectionInterface, \Countable {
    
    /**
     * @var string
     */
    protected $name = '';
    
    /**
     * @var array
     */
    protected $data = array();
    
    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return ArrayCollection
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getKeys() {
        return array_keys($this->data);
    }
    
    /**
     * @param string $key
     * @return Entity
     * @throws MissingKeyException
     */
    public function getKey($key) {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            throw new MissingKeyException('Key "' . $key . '" could not be located.');
        }
    }
    
    /**
     * @param string $key
     * @return mixed
     * @throws MissingKeyException
     */
    public function getValueForKey($key) {
        return $this->getKey($key)->getValue();
    }
    
    public function setValueForKey($key, $value) {
        $entity = new Entity();
        $entity->setKey($key)->setValue($value);
        $this->data[$key] = $entity;
    }
    
    /**
     * @param string $key
     * @return boolean
     */
    public function keyExists($key) {
        return array_key_exists($key, $this->data);
    }
    
    /**
     * @return int
     */
    public function count() {
        return count($this->data);
    }
    
}
