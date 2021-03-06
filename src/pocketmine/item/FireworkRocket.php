<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\entity\FireworksRocket;
use pocketmine\entity\utils\FireworksUtils;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\Random;

class FireworkRocket extends Item{

	public $spread = 5.0;

	public function __construct(int $meta = 0){
		parent::__construct(self::FIREWORKS, $meta, "Firework Rocket");
	}

	public function getMaxStackSize() : int{
		return 16;
	}

	public function onClickAir(Player $player, Vector3 $directionVector): bool{
		$random = new Random();
		$motion = $player->getDirectionVector()->add(0,1.2);
		$nbt = FireworksUtils::createNBTforEntity($player, $motion, $this, $this->spread, $random, $player->getYaw(), $player->getPitch());
		$fireworkRocket = new FireworksRocket($player->level, $nbt, $player, clone $this, $random);
		$player->level->addEntity($fireworkRocket);

		if($fireworkRocket instanceof Entity){
			--$this->count;
			$fireworkRocket->spawnToAll();
			$player->setMotion($motion);
			$fireworkRocket->setMotion($motion->multiply(2.6));
			return true;
		}

		return false;
	}		
}