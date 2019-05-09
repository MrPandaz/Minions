<?php

namespace Minions\miner;

use pocketmine\Player;
use pocketmine\command\CommandSender;

  public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        if(strtolower($command->getName()) === "minions"){
            if(count($args) < 2){
if(isset($args[0])){
                    switch($args[0]){
                        
                        case "miner":
                        $this->give();
                        break;
                    }
                }
            }
        }
        return true;
    }
    public function give(): void
    {
        foreach(Server::getInstance()->getOnlinePlayers() as $player):
        $boss = Item::get(383,100,1);
            $boss->setCustomName("§l§dMiner Minion");
			$boss->setLore([
        "A Minion Forged in The Fires Of The Mountain Erebos",
        "",
        "Place It And Get Started"
			]);
        $player->getInventory()->addItem($boss);
		$player->addTitle(c::LIGHT_PURPLE . "Minion Summoned...");
        endforeach;
    }
    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
		
		if($event->getItem()->getId() === 383){
            $damage = $event->getItem()->getDamage();
            $block = $event->getBlock();
            switch($damage){
                case 100:
                $nbt = new CompoundTag("", [
                    "Pos" => new ListTag("Pos", [
                     new DoubleTag("", $block->x),
                     new DoubleTag("", $block->y + 2),
                     new DoubleTag("", $block->z)
                    ]),
                    "Motion" => new ListTag("Motion", [
                    new DoubleTag("", 0),
                    new DoubleTag("", 0),
                    new DoubleTag("", 0)
                    ]),
                    "Rotation" => new ListTag("Rotation", [
                      new FloatTag("", mt_rand() / mt_getrandmax() * 360),
                      new FloatTag("", 0)
                    ]),
                    ]);
                    
                      $entity = Entity::createEntity("Zombie", $player->getLevel(), $nbt);
                      $entity->setMaxHealth(500);
                      $entity->setHealth(500);
                      $entity->setScale(.5);
					  $entity->getArmorInventory()->setHelmet(Item::get(310,0,1));
					  $entity->getArmorInventory()->setChestplate(Item::get(311,0,1));
					  $entity->getArmorInventory()->setLeggings(Item::get(312,0,1));
					  $entity->getArmorInventory()->setBoots(Item::get(313,0,1));
					  $entity->setNameTag(c::LIGHT_PURPLE . c::BOLD . "Miner Minion" . "\n" . c::AQUA . "HP " . c::GRAY . $entity->getHealth() . c::GREEN . "/" . c::GRAY . $entity->getMaxHealth());
                      $entity->spawnToAll();
                      $player->getLevel()->addSound(new AnvilFallSound($player));
                      $player->sendMessage("Miner Minion Spawned");
                      $player->getInventory()->removeItem(Item::get(383, 100, 1));
                break;
            }
        }
    }
}
