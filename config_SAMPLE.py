###############################################################################
#                    HBMonv2 Configuration File Example
#         Copyright (C) 2013-2018 Cortney T. Buffington, N0MJS n0mjs@me.com
#         Copyright (C) 2025 Shane aka, ShaYmez <shane@freestar.network>
###############################################################################

# ---- FEATURE TOGGLES --------------------------------------------------------
CONFIG_INC      = True    # Include HBlink stats
HOMEBREW_INC    = True    # Display Homebrew Peers status
LASTHEARD_INC   = True    # Display lastheard table on main page
BRIDGES_INC     = False   # Display Bridge status and button
EMPTY_MASTERS   = False   # Enable (True) or Disable (False) empty masters in status

# ---- CONNECTION SETTINGS ----------------------------------------------------
HBLINK_IP       = '127.0.0.1'    # HBlink's IP Address
HBLINK_PORT     = 4321           # HBlink's TCP reporting socket
FREQUENCY       = 10             # Frequency (secs) to push updates to web clients
CLIENT_TIMEOUT  = 0              # Timeout clients after N secs (0=disable)

# ---- NETWORK FILTERING ------------------------------------------------------
# To hide in lastheard: provide comma-separated NETWORK IDs
# Example: "260210,260211,260212"
OPB_FILTER      = ""

# ---- ALIAS FILES AND PATHS --------------------------------------------------
PATH            = './'                           # Base path (MUST END IN '/')
PEER_FILE       = 'peer_ids.json'                # Auto-download
SUBSCRIBER_FILE = 'subscriber_ids.json'          # Auto-download
TGID_FILE       = 'talkgroup_ids.json'           # User provided
LOCAL_SUB_FILE  = 'local_subscriber_ids.json'    # Optional, user provided ('' if not used)
LOCAL_PEER_FILE = 'local_peer_ids.json'          # Optional, user provided ('' if not used)
LOCAL_TGID_FILE = 'local_talkgroup_ids.json'     # Optional, user provided ('' if not used)
FILE_RELOAD     = 14                             # Days before reloading MARC files

# ---- ALIAS DOWNLOAD URLS ----------------------------------------------------
PEER_URL        = 'https://radioid.net/static/rptrs.json'
SUBSCRIBER_URL  = 'https://radioid.net/static/users.json'

# ---- LOGGING SETTINGS -------------------------------------------------------
LOG_PATH        = './log/'               # MUST END IN '/'
LOG_NAME        = 'hbmon.log'

###############################################################################
#                        END OF CONFIGURATION FILE
###############################################################################
