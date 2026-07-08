
link: https://www.reddit.com/r/bash/comments/12lz3kb/is_it_possible_to_make_zsh_look_like_gitbash/

touch ~/.zshrc

~~~
autoload -Uz vcs_info
precmd() { vcs_info }
zstyle ':vcs_info:git:*' formats '(%b)'
setopt PROMPT_SUBST
NEWLINE=$'\n'
PROMPT='%F{green}%n@%m%f %F{magenta}arm64 %F{yellow}%~ %F{cyan}${vcs_info_msg_0_}%f %F{reset_color}${NEWLINE}$ '
~~~

