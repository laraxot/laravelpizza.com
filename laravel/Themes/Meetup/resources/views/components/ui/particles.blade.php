<div 
    x-data="particles()" 
    x-init="init()"
    class="fixed inset-0 pointer-events-none z-0 particles-container"
    aria-hidden="true"
>
    <canvas 
        x-ref="canvas"
        id="particleCanvas"
        class="w-full h-full"
    ></canvas>
</div>

<script>
function particles() {
    return {
        canvas: null,
        ctx: null,
        particles: [],
        mouseX: 0,
        mouseY: 0,
        animationId: null,
        
        init() {
            if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                return;
            }

            this.canvas = this.$refs.canvas;
            this.ctx = this.canvas.getContext('2d');
            
            this.resize();
            window.addEventListener('resize', () => this.resize());
            
            // Track mouse position
            document.addEventListener('mousemove', (e) => {
                this.mouseX = e.clientX;
                this.mouseY = e.clientY;
            });
            
            // Create particles
            this.createParticles();
            
            // Start animation
            this.animate();
        },
        
        resize() {
            const dpr = window.devicePixelRatio || 1;
            this.canvas.width = window.innerWidth * dpr;
            this.canvas.height = window.innerHeight * dpr;
            this.ctx.setTransform(1, 0, 0, 1, 0, 0);
            this.ctx.scale(dpr, dpr);
            this.canvas.style.width = window.innerWidth + 'px';
            this.canvas.style.height = window.innerHeight + 'px';
        },
        
        createParticles() {
            const count = Math.floor((window.innerWidth * window.innerHeight) / 15000);
            const colors = [
                'rgba(239, 68, 68, 0.4)',   // red-500
                'rgba(249, 115, 22, 0.3)',  // orange-500
                'rgba(234, 88, 12, 0.3)',    // orange-600
                'rgba(220, 38, 38, 0.3)',   // red-600
                'rgba(252, 165, 165, 0.2)', // red-300
            ];
            
            for (let i = 0; i < count; i++) {
                this.particles.push({
                    x: Math.random() * window.innerWidth,
                    y: Math.random() * window.innerHeight,
                    radius: Math.random() * 3 + 1,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    vx: (Math.random() - 0.5) * 0.5,
                    vy: (Math.random() - 0.5) * 0.5,
                    baseVx: (Math.random() - 0.5) * 0.5,
                    baseVy: (Math.random() - 0.5) * 0.5,
                });
            }
        },
        
        animate() {
            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
            
            this.particles.forEach(p => {
                // Mouse interaction - particles move away from mouse
                const dx = p.x - this.mouseX;
                const dy = p.y - this.mouseY;
                const dist = Math.sqrt(dx * dx + dy * dy);
                const maxDist = 150;
                
                if (dist < maxDist) {
                    const force = (maxDist - dist) / maxDist;
                    const angle = Math.atan2(dy, dx);
                    p.vx += Math.cos(angle) * force * 0.3;
                    p.vy += Math.sin(angle) * force * 0.3;
                }
                
                // Apply velocity
                p.x += p.vx;
                p.y += p.vy;
                
                // Gradually return to base velocity
                p.vx += (p.baseVx - p.vx) * 0.02;
                p.vy += (p.baseVy - p.vy) * 0.02;
                
                // Wrap around screen
                if (p.x < 0) p.x = window.innerWidth;
                if (p.x > window.innerWidth) p.x = 0;
                if (p.y < 0) p.y = window.innerHeight;
                if (p.y > window.innerHeight) p.y = 0;
                
                // Draw particle
                this.ctx.beginPath();
                this.ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                this.ctx.fillStyle = p.color;
                this.ctx.fill();
                
                // Draw connections between nearby particles
                this.particles.forEach(p2 => {
                    if (p === p2) return;
                    const dx = p.x - p2.x;
                    const dy = p.y - p2.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    
                    if (dist < 100) {
                        this.ctx.beginPath();
                        this.ctx.moveTo(p.x, p.y);
                        this.ctx.lineTo(p2.x, p2.y);
                        this.ctx.strokeStyle = `rgba(239, 68, 68, ${0.1 * (1 - dist / 100)})`;
                        this.ctx.stroke();
                    }
                });
            });
            
            this.animationId = requestAnimationFrame(() => this.animate());
        },
        
        destroy() {
            if (this.animationId) {
                cancelAnimationFrame(this.animationId);
            }
            window.removeEventListener('resize', this.resize);
            document.removeEventListener('mousemove', this.handleMouseMove);
        }
    };
}
</script>

<style>
.particles-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    overflow: hidden;
}

.particles-container canvas {
    display: block;
}
</style>
