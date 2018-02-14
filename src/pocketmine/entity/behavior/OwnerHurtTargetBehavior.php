<?php

/*
 *               _ _
 *         /\   | | |
 *        /  \  | | |_ __ _ _   _
 *       / /\ \ | | __/ _` | | | |
 *      / ____ \| | || (_| | |_| |
 *     /_/    \_|_|\__\__,_|\__, |
 *                           __/ |
 *                          |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author TuranicTeam
 * @link https://github.com/TuranicTeam/Altay
 *
 */

declare(strict_types=1);

namespace pocketmine\entity\behavior;

use pocketmine\entity\Living;
use pocketmine\Player;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class OwnerHurtTargetBehavior extends Behavior{
	
	public function canStart() : bool{
		$owner = $this->mob->getOwningEntity();
		
		if($owner !== null){
			$cause = $owner->getLastAttackCause();
			if($cause instanceof EntityDamageByEntityEvent){
				$this->mob->setTargetEntity($cause->getEntity());
				return true;
			}
		}
		
		return false;
	}
	
	public function canContinue() : bool{
		return false:
	}
}