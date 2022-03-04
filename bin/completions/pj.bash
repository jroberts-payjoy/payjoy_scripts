_pj() {
  COMPREPLY=()
  local word="${COMP_WORDS[COMP_CWORD]}"

  if [ "$COMP_CWORD" -eq 1 ]; then
    COMPREPLY=( $(compgen -W "$(pj commands)" -- "$word") )
  elif [ "$COMP_CWORD" -gt 1 ]; then
  	commands="$(pj commands ${COMP_WORDS[@]})"
  	if [ "$commands" ]; then
    	COMPREPLY=( $(compgen -W "$commands" -- "$word") )
    else
    	return 1
    fi
  fi
}

complete -o default -F _pj pj
