https://pixelpoint.io/blog/web-optimized-video-ffmpeg/

ffmpeg -i in.mp4 -c:v libvpx-vp9 -threads 4 out.mp4

ffmpeg -i input.mp4 -c:v libvpx-vp9 -preset ultrafast -b:v 1M -c:a libvorbis output.webm
ffmpeg -i input.mp4 -c:v libvpx-vp9 -preset ultrafast -b:v 1M -c:a libvorbis -threads 4 -speed 4 output.webm


-i input.mp4: Specifica il file di input.
-c:v libvpx-vp9: Utilizza il codec video VP9 per WebM.
-preset ultrafast: Imposta il preset di velocità su ultrafast.
-b:v 1M: Imposta il bitrate video a 1 Mbps (puoi modificarlo in base alle tue esigenze).
-c:a libvorbis: Utilizza il codec audio Vorbis
-threads 4: utilizza 4 thread per l'elaborazione, aumentando la velocità di conversione sfruttando il multi-threading.
-speed 4: imposta la velocità del codec VP9 a 4, che è un valore elevato per massimizzare la velocità di codifica.


-------------------------------------------

ffmpeg -h encoder=hevc_nvenc  



/usr/bin/ffmpeg -y -i input.mp4 -f webm 
    -preset ultrafast 
    -threads 12 
    -vcodec libvpx-vp9 
    -acodec libvorbis 
    -b:v 1000k 
    -refs 6 
    -coder 1 
    -sc_threshold 40 
    -flags +loop 
    -me_range 16 
    -subq 7 
    -i_qfactor 0.71 
    -qcomp 0.6 
    -qdiff 4 
    -trellis 1 
    -b:a 128k 
    output.webm

----------------------------------
ffmpeg -h encoder=hevc_nvenc  