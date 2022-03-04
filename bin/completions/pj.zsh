if [[ ! -o interactive ]]; then
    return
fi

compctl -K _pj pj

_pj() {
  local word words completions
  read -cA words

  if [ "${#words}" -eq 2 ]; then
    completions="$(pj commands)"
  elif [ "${#words}" -gt 2 ]; then
    completions="$(pj commands "$words")"
  fi

  reply=("${(ps:\n:)completions}")
}
