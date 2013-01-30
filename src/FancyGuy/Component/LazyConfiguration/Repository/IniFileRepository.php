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

namespace FancyGuy\Component\LazyConfiguration\Repository;

use FancyGuy\Component\LazyConfiguration\Collection\ArrayCollection;
use FancyGuy\Component\LazyConfiguration\Exception\MissingCollectionException;

/**
 * Description of IniFileRepository
 *
 * @author Steve Buzonas <steve@fancyguy.com>
 */
class IniFileRepository extends FilesystemRepository {
    
    protected $collections = array();
    
    public function collectionExists($name) {
        if (isset($this->collections[$name])) {
            return true;
        }
        return parent::collectionExists($name . '.ini');
    }
    
    public function getCollection($name) {
        if (isset($this->collections[$name])) {
            return $this->collections[$name];
        } else if ($this->collectionExists($name)) {
            return $this->loadCollection($name);
        }
        throw new MissingCollectionException('Could not locate collection "' . $name . '"');
    }
    
    protected function loadCollection($name) {
        $ini_file = $this->path . DIRECTORY_SEPARATOR . $name . '.ini';
        
        $data = parse_ini_file($ini_file);
        
        $collection = new ArrayCollection();
        
        $collection->setName($name);
        
        foreach ($data as $key => $value) {
            $collection->setValueForKey($key, $value);
        }
        
        $this->collections[$name] = $collection;
        
        return $this->collections[$name];
    }
    
}
