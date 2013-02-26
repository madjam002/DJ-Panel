#####################################
###### DJ Panel LiquidSoap App ######
#####################################

######
# Cross Fade Transition
############

# A similar transition,
# which does a cross-fading from A to B
# and adds a jingle
def transition(j,a,b)
  add(normalize=false,
      [ fade.initial(b),
        sequence(merge=true,
                [blank(duration=1.),j,fallback([])]),
        fade.final(a) ])
end

######
# Configuration
############
harbor_port = 1280
telnet_port = 1234

######
# Set up some stuff
############
set("log.file.path", "./liquidsoap.log")

######
# Enable Telnet to let the web interface control Liquidsoap
############
set("server.telnet", true)
set("server.telnet.port", telnet_port)

######
# Harbor Configuration
############
set("harbor.bind_addr","0.0.0.0")
set("harbor.port", harbor_port)

# TODO Auto DJ playlists

# srv/djpanel/music/1.mp3

beep = single("/srv/djpanel/music/beep.mp3")
auto_dj = single("/srv/djpanel/music/1.mp3")

######
# Live Source
############
# TODO live source authentication using DJ panel credentials
live = input.harbor("live", password="password")
#live = input.http("http://109.111.217.240:8000/dj")

######
# Figure out which source should go live
############
radio = fallback(track_sensitive=false,
    #transitions=[transition(beep)],
    [live, once(beep), auto_dj])
#radio = live
#radio = auto_dj

######
# Stream Radio to Icecast / Shoutcast
############
output.icecast.vorbis(
    host = "109.111.217.240", port = 8000, password = "j5dJbfm9WQCe", mount = "live",
    description = "dat.Radio", name = "Wooo", genre = "Awesomeness", url = "http://www.datgaming.net/",
    fallible = true, radio)


## FUNCTIONS

######
# Create new Harbor Live Source
############
