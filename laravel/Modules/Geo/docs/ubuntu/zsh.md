~~~ bash
sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"
touch ~/.zshrc
code ~/.zshrc
~~~

~~~ bash
autoload -Uz vcs_info
precmd() { vcs_info }
zstyle ':vcs_info:git:*' formats '(%b)'
setopt PROMPT_SUBST
NEWLINE=$'\n'
PROMPT='%F{green}%n@%m%f %F{yellow}%~ %F{cyan}${vcs_info_msg_0_}%f %F{reset_color}${NEWLINE}$ '
~~~

~~~ bash
source ~/.zshrc
~~~

usefull links:
- https://zsh-prompt-generator.site/

