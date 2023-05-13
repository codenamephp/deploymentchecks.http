<?php declare(strict_types=1);
/*
 *  Copyright 2023 Bastian Schwarz <bastian@codename-php.de>.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

namespace de\codenamephp\deploymentchecks\http\CssSelector;

/**
 * Interface to run a CSS selector and check if it exists
 */
interface CssSelectorInterface {

  /**
   * Runs the selector and returns true if it matches at least one element, false otherwise
   *
   * @param string $selector The selector to run
   * @return bool True if the selector matches at least one element, false otherwise
   */
  public function exists(string $selector) : bool;
}
