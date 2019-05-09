<?php

namespace Test;

use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as c;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\level\sound\AnvilFallSound;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\command\{Command, CommandSender};
use pocketmine\nbt\{NBT, tag\CompoundTag, tag\IntTag, tag\ListTag, tag\StringTag, tag\FloatTag, tag\DoubleTag};
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->getLogger()->notice("[HysteriaBosses] Has Been Enabled!");
    }

    public function onDisable(){
        $this->getLogger()->critical("[HysteriaBosses] Has Been Disabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        if(strtolower($command->getName()) === "boss"){
            if(count($args) < 2){

                if(isset($args[0])){

                    switch($args[0]){
                        
                        case "zeus":

                        /*$boss = Item::get(383,100,1);
                        $boss->setCustomName(c::AQUA . "Zeus " . c::GREEN . "Boss" . PHP_EOL .
						c::LIGHT_PURPLE . "Level: " . c::GRAY . "1" . PHP_EOL .
						c::LIGHT_PURPLE . "Reward: " . c::GRAY . "OP Items" . PHP_EOL .
						c::LIGHT_PURPLE . "Health: " . c::GRAY . "500" . PHP_EOL .
						c::LIGHT_PURPLE . "Activate: " . c::GRAY . "Right-Click"); */
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
            $boss->setCustomName("§l§dWarrior Boss §r§7(Right-Click) §f(500 HP)");
			$boss->setLore([
			"§7Be Carefull of where you activate him",
			"§7he aborbs the power of the gods and can",
			"§7destroy anything blocking his path to",
			"§7a battles victory",
			"",
			"§l§3Level: §r§7[§b1§7]",
			"",
			"§l§cWARNING:§r§7 Bosses may drain your armor",
			"§7and custom enchant directly from your body",
			"§7while facing him in combat"
			]);
        $player->getInventory()->addItem($boss);
		$player->addTitle(c::LIGHT_PURPLE . "Warrior Summoned");
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
                      $entity->setScale(1);
					  $entity->getArmorInventory()->setHelmet(Item::get(310,0,1));
					  $entity->getArmorInventory()->setChestplate(Item::get(311,0,1));
					  $entity->getArmorInventory()->setLeggings(Item::get(312,0,1));
					  $entity->getArmorInventory()->setBoots(Item::get(313,0,1));
					  $entity->setNameTag(c::LIGHT_PURPLE . c::BOLD . "Warrior Boss" . "\n" . c::AQUA . "HP " . c::GRAY . $entity->getHealth() . c::GREEN . "/" . c::GRAY . $entity->getMaxHealth());
                      $entity->spawnToAll();
                      $player->getLevel()->addSound(new AnvilFallSound($player));
                      $player->sendTip(c::BOLD . c::AQUA . "Warrior Boss" . c::GREEN . "Summoned");
                      $player->getInventory()->removeItem(Item::get(383, 100, 1));
                break;
            }
        }
    }
}