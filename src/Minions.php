<?php
namespace Minions;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{
	
    public function onEnable(){
        $this->getLogger()->info("Bosses Enabling...");
    }
	
    public function onDisable(){
        $this->getLogger()->info("[Bosses Disabling...");
    }
	
/* 
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
*/
