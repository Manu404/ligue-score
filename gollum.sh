#!/bin/bash
SCRIPTPATH="$(readlink -f "$0")"
cd "$(dirname $SCRIPTPATH)"

cd ./scripts

source vars.sh

while test $# -gt 0; do
 case "$1" in
	settle)
		echo "Gollum got a new home! (ln in ~/bin/gollum, make it globally available for current user)"
		source ./install_gollum.sh
		exit;;
	setup:back)
		echo "Setup backend devenv."; 
		source ./setup_composer.sh; 
		exit;;
	build:back)
		echo "Build backend"; 
		source ./build_backend.sh; 
		exit;;
	publish:back:local)
		echo "Clean test + dependencies"; 
		source ./clean_testdep.sh; 
		exit;;
	help)
		echo "======================================================================================"
		echo "=============== b e == c a r e f u l./:%£*¨%µ%*jdj'*¨£%$^)z¨^àçgu^ ============ damn ="
		echo "======================================================================================"
		echo "  init .................................. Default init. (init.sh)"
		exit 0
		;;
	*)
	  echo "Unknown order, type 'gollum help' for available commands"
      break
      ;;
  esac
done