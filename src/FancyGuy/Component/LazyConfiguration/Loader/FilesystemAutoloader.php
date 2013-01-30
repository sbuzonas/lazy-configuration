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

namespace FancyGuy\Component\LazyConfiguration\Loader;

use FancyGuy\Component\LazyConfiguration\Repository\RepositoryInterface;

/**
 * Description of FilesystemAutoloader
 *
 * @author Steve Buzonas <steve@fancyguy.com>
 */
class FilesystemAutoloader implements ConfigurationLoaderInterface {
    
    const NAMESPACE_SEPARATOR = '::';
    const KEY_SEPARATOR = ':';
    
    /**
     * @var RepositoryInterface
     */
    protected $repository;
    
    public function __construct(RepositoryInterface $repository) {
        $this->repository = $repository;
    }
    
    public function getConfigurationValue($key) {
        $key_path = implode(DIRECTORY_SEPARATOR, preg_split('/(.+?\w):([^:].+)/u', $key, 1));
        list($path, $key_name) = explode(':', $key_path, 1);
        return $this->repository->getCollection($path)->getValueForKey($key_name);
    }
    
}
