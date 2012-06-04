if(preg_match('/# Enable IPV6 and IPV4 together[\s\S]+.*# End/',$a))
{
$cc="# Enable IPV6 and IPV4 together\n";
$cc=$cc."server.use-ipv6 = \"enable\"\n";
$cc=$cc."\$SERVER[\"socket\"] == \"0.0.0.0:".$newport."\" {\n";
$cc=$cc."ssl.engine = \"enable\"\n";
$cc=$cc."ssl.pemfile = \"/ximorun/ximoetc/server.pem\"\n }\n";
$cc=$cc."# End";
$a=preg_replace('/# Enable IPV6 and IPV4 together[\s\S]+.*# End/',$cc, $a);
}