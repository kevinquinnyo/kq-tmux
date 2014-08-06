kq-tmux
=======

My tmux config + scripts

Required:

nodejs

Uses:

Ubersmith API + WHMCS API to pull counts of tickets in need of action.
Nodejs module:  https://github.com/nadavbar/node-spotify-webhelper to display current spotify track in status bar

The Ubersmith and WHMCS ticket pull is kind of specific to my job, but you can just leave them disabled and remove the widget in the status-bar if you don't need it.


Installation
------------

sudo apt-get install tmux

sudo apt-get install nodejs

```
cd ~
git clone git@github.com:kevinquinnyo/kq-tmux.git
cd kq-tmux

\# Now move my tmux.conf into $HOME where tmux looks for it:
[[ -f ~/.tmux.conf ]] && mv ~/.tmux.conf ~/tmux-before-kq-tmux.bak
mv .tmux.conf ~/.tmux.conf
tmux source-file ~/.tmux.conf

\# install spotify helper
cd spotify/
npm install node-spotify-webhelper

\# The remote api and imap functions are disabled until you set the appropriate values in ~/kq-tmux/config.json and set enabled to true.

\# To see keybindings:
tmux list-keys
```

Caveats
-------

If your node binary is called 'nodejs' as opposed to 'node', you may have to edit the ~/.tmux.conf or add to your ~/.bashrc the following:

alias node=$(which nodejs)

For the battery charge %, you may have to edit bat.sh to find the correct battery device for your system.

For the spotify current track listing, you may have to change the port for the spotify local http server in ~/kq-tmux/spotify/get-current-track.js .  Check netstat -tnlp with spotify running.



