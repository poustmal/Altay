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

namespace pocketmine\item\enchantment;

use pocketmine\event\entity\EntityDamageEvent;

class ProtectionEnchantment extends Enchantment{
	/** @var float */
	protected $typeModifier;
	/** @var int[]|null */
	protected $applicableDamageTypes = null;

    /**
     * ProtectionEnchantment constructor.
     *
     * @param int $id
     * @param string $name
     * @param int $rarity
     * @param int $slot
     * @param int $maxLevel
     * @param float $typeModifier
     * @param int[]|null $applicableDamageTypes EntityDamageEvent::CAUSE_* constants which this enchantment type applies to, or null if it applies to all types of damage.
     * @param int $repairCost
     */
	public function __construct(int $id, string $name, int $rarity, int $slot, int $maxLevel, float $typeModifier, ?array $applicableDamageTypes, int $repairCost = 1){
		parent::__construct($id, $name, $rarity, $slot, $maxLevel, $repairCost);

		$this->typeModifier = $typeModifier;
		if($applicableDamageTypes !== null){
			$this->applicableDamageTypes = array_flip($applicableDamageTypes);
		}
	}

	/**
	 * Returns the multiplier by which this enchantment type's EPF increases with each enchantment level.
	 * @return float
	 */
	public function getTypeModifier() : float{
		return $this->typeModifier;
	}

	/**
	 * Returns the base EPF this enchantment type offers for the given enchantment level.
	 * @param int $level
	 *
	 * @return int
	 */
	public function getProtectionFactor(int $level) : int{
		return (int) floor((6 + $level ** 2) * $this->typeModifier / 3);
	}

	/**
	 * Returns whether this enchantment type offers protection from the specified damage source's cause.
	 * @param EntityDamageEvent $event
	 *
	 * @return bool
	 */
	public function isApplicable(EntityDamageEvent $event) : bool{
		return $this->applicableDamageTypes === null or isset($this->applicableDamageTypes[$event->getCause()]);
	}
}
