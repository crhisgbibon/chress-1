<?php

declare(strict_types=1);

/** View Class
 * 
 * 
 * 
*/

class UserView
{

  public function __construct()
  {

  }

  private function Admin() : string
  {
    return <<<VIEW

    <ul class="projectLinks" data-name="Billit_admin">
      <div class="projectDisplay">
        <li><a href="billit_admin/index.php">Billit Admin</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="PHP Version">
      <div class="projectDisplay">
        <li><a href="version/version.php">PHP Version</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Assets">
      <div class="projectDisplay">
        <li><a href="assets/assets.php">Assets</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Elements">
      <div class="projectDisplay">
        <li><a href="elements/elements.php">Elements</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Template">
      <div class="projectDisplay">
        <li><a href="template/index.php">Template</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Cards">
      <div class="projectDisplay">
        <li><a href="cards/index.php">Cards</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Updates 1 - Long Poll">
      <div class="projectDisplay">
        <li><a href="updates1/index.php">Updates 1 - Long Poll</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Updates 2 - SSE">
      <div class="projectDisplay">
        <li><a href="updates2/index.php">Updates 2 - SSE</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Email">
      <div class="projectDisplay">
        <li><a href="email/index.php">Email</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Sandbox">
      <div class="projectDisplay">
        <li><a href="sandbox/index.php">Sandbox</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Tracker">
      <div class="projectDisplay">
        <li><a href="tracker/index.php">Tracker</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Gallery">
    <div class="projectDisplay">
      <li><a href="gallery/index.html">Gallery</a></li>
      <div class="infoGap"></div>
      <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Panda">
    <div class="projectDisplay">
      <li><a href="panda/index.html">Panda</a></li>
      <div class="infoGap"></div>
      <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Three Dimensions">
    <div class="projectDisplay">
      <li><a href="threedimensions/index.php">Three Dimensions</a></li>
      <div class="infoGap"></div>
      <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Chat">
    <div class="projectDisplay">
      <li><a href="chat/index.php">Chat</a></li>
      <div class="infoGap"></div>
      <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="Podcasts">
    <div class="projectDisplay">
      <li><a href="podcasts/index.php">Podcasts</a></li>
      <div class="infoGap"></div>
      <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="States of Strife">
    <div class="projectDisplay">
      <li><a href="statesofstrife/index.php">States of Strife</a></li>
      <div class="infoGap"></div>
      <button class="projectInfo">X</button>
      </div>
    </ul>

    <ul class="projectLinks" data-name="FractalForest">
      <div class="projectDisplay">
        <li><a href="fractalforest/index.php">Fractal Forest</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
        </div>
    </ul>

    <ul class="projectLinks" data-name="CronManager">
      <div class="projectDisplay">
        <li><a href="cronmanager/index.php">Cron Manager</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo">X</button>
        </div>
    </ul>

    VIEW; 
  }

  private function User() : string
  {
    return <<<VIEW

    <ul class="projectLinks" data-name="Wordle+">
      <div class="projectDisplay">
        <li><a href="wordleplus/index.php">Wordle+</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i1`);'>?</button>
      </div>
      <div class="infoPane" id="i1" style="display:none;">
        Play and solve wordle puzzles.
      </div>
    </ul>

    <ul class="projectLinks" data-name="Anagram">
      <div class="projectDisplay">
        <li><a href="anagram/index.php">Anagram</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i2`);'>?</button>
      </div>
      <div class="infoPane" id="i2" style="display:none;">
        Finds anagrams from search input.
      </div>
    </ul>

    <ul class="projectLinks" data-name="Chess">
      <div class="projectDisplay">
        <li><a href="chess/index.php">Chess</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i3`);'>?</button>
      </div>
      <div class="infoPane" id="i3" style="display:none;">
        Play chess against AI and access an archive of historic professional games.
      </div>
    </ul>

    <ul class="projectLinks" data-name="MazeMaker">
      <div class="projectDisplay">
        <li><a href="mazemaker/index.php">Maze Maker</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i4`);'>?</button>
      </div>
      <div class="infoPane" id="i4" style="display:none;">
        Procedurally creates mazes for the user to solve.
      </div>
    </ul>

    <ul class="projectLinks" data-name="XO">
      <div class="projectDisplay">
        <li><a href="xo/index.php">XO</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i5`);'>?</button>
      </div>
      <div class="infoPane" id="i5" style="display:none;">
        Play tic tac toe against AI.
      </div>
    </ul>

    <ul class="projectLinks" data-name="WordWheel">
      <div class="projectDisplay">
        <li><a href="wordwheel/index.php">Word Wheel</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i6`);'>?</button>
      </div>
      <div class="infoPane" id="i6" style="display:none;">
        Procedurally generates word wheel puzzles.
      </div>
    </ul>

    <ul class="projectLinks" data-name="GameOfLife">
      <div class="projectDisplay">
        <li><a href="gameoflife/index.php">Game of Life</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i7`);'>?</button>
      </div>
      <div class="infoPane" id="i7" style="display:none;">
        An implementation of John Conway's Game of Life.
      </div>
    </ul>

    <ul class="projectLinks" data-name="Larder">
      <div class="projectDisplay">
        <li><a href="larder/index.php">Larder</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i9`);'>?</button>
      </div>
      <div class="infoPane" id="i9" style="display:none;">
        A food management application. Calory counter, recipe database, cooking assistant and budgeting tool.
      </div>
    </ul>

    <ul class="projectLinks" data-name="Flashcards">
      <div class="projectDisplay">
        <li><a href="flashcards/index.php">Flashcards</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i10`);'>?</button>
      </div>
      <div class="infoPane" id="i10" style="display:none;">
        Create, manage and play with flashcards for study and memorization.
      </div>
    </ul>

    <ul class="projectLinks" data-name="Billit">
      <div class="projectDisplay">
        <li><a href="billit/index.php">Billit</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i11`);'>?</button>
      </div>
      <div class="infoPane" id="i11" style="display:none;">
        Time invoicing tool with reporting functions.
      </div>
    </ul>

    <ul class="projectLinks" data-name="TTSReader">
      <div class="projectDisplay">
        <li><a href="ttsreader/index.php">TTS Reader</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i13`);'>?</button>
      </div>
      <div class="infoPane" id="i13" style="display:none;">
        Text to speech reader and archive of various classics and legal texts.
      </div>
    </ul>

    <ul class="projectLinks" data-name="SoundSquares">
      <div class="projectDisplay">
        <li><a href="soundsquares/index.php">Sound Squares</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i14`);'>?</button>
      </div>
      <div class="infoPane" id="i14" style="display:none;">
        Touch screen instrument, a Javascript based synthesizer.
      </div>
    </ul>

    <ul class="projectLinks" data-name="RSSReader">
      <div class="projectDisplay">
        <li><a href="rssreader/index.php">RSS Reader</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i15`);'>?</button>
      </div>
      <div class="infoPane" id="i15" style="display:none;">
        Aggregates news articles.
      </div>
    </ul>

    <ul class="projectLinks" data-name="PixelPad">
      <div class="projectDisplay">
        <li><a href="pixelpad/index.php">Pixel Pad</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i16`);'>?</button>
      </div>
      <div class="infoPane" id="i16" style="display:none;">
        Image manipulation tool.
      </div>
    </ul>

    <ul class="projectLinks" data-name="Jumbler">
      <div class="projectDisplay">
        <li><a href="jumbler/index.php">Jumbler</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i17`);'>?</button>
      </div>
      <div class="infoPane" id="i17" style="display:none;">
        Uses user provided images to generate digital jigsaw puzzles.
      </div>
    </ul>

    <ul class="projectLinks" data-name="LSystems">
      <div class="projectDisplay">
        <li><a href="lsystems/index.php">L-Systems</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`i19`);'>?</button>
      </div>
      <div class="infoPane" id="i19" style="display:none;">
        Renders various pre-installed fractals and L-systems and allows user to generate custom models.
      </div>
    </ul>

    <ul class="projectLinks" data-name="Boids">
      <div class="projectDisplay">
        <li><a href="boids/index.php">Boids</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`iBoids`);'>?</button>
      </div>
      <div class="infoPane" id="iBoids" style="display:none;">
        Murmuration animation.
      </div>
    </ul>

    <ul class="projectLinks" data-name="EPL">
      <div class="projectDisplay">
        <li><a href="epl/index.php">EPL</a></li>
        <div class="infoGap"></div>
        <button class="projectInfo" onclick='ToggleInfo(`iEPL`);'>?</button>
      </div>
      <div class="infoPane" id="iEPL" style="display:none;">
        Premier league fantasy game.
      </div>
    </ul>

    VIEW; 
  }

  public function render($userState) : string
  {
    $userView = $this->User();

    $adminView = "";

    if($userState === "admin")
    {
      $adminView = $this->Admin();
    }

    return <<<VIEW

    <div id="projects">

      {$userView}

      {$adminView}

    </div>

    VIEW;
  }
}