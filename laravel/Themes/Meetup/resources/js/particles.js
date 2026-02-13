/**
 * Interactive Particle System for LaravelPizza Meetup Theme
 * Based on zero-gravity physics with mouse interaction
 * 
 * Features:
 * - Floating particles with zero-gravity simulation
 * - Mouse repulsion effect
 * - Smooth acceleration and friction
 * - Responsive canvas sizing
 * - Performance optimized with requestAnimationFrame
 */

class ParticleSystem {
    constructor(options = {}) {
        this.canvas = null;
        this.ctx = null;
        this.particles = [];
        this.mouse = { x: null, y: null, radius: 150 };
        this.animationId = null;
        
        // Configuration
        this.config = {
            particleCount: options.particleCount || 80,
            baseRadius: options.baseRadius || 2,
            maxRadius: options.maxRadius || 4,
            baseSpeed: options.baseSpeed || 0.5,
            mouseRadius: options.mouseRadius || 150,
            colors: options.colors || [
                'rgba(239, 68, 68, 0.8)',    // red-500
                'rgba(249, 115, 22, 0.8)',   // orange-500
                'rgba(6, 182, 212, 0.8)',    // cyan-500
                'rgba(139, 92, 246, 0.8)',   // violet-500
                'rgba(236, 72, 153, 0.8)'    // pink-500
            ],
            acceleration: options.acceleration || 0.05,
            friction: options.friction || 0.98,
            ...options
        };
    }

    /**
     * Initialize the particle system
     */
    init() {
        this.canvas = document.getElementById('particleCanvas');
        if (!this.canvas) {
            console.warn('Particle canvas not found');
            return;
        }

        this.ctx = this.canvas.getContext('2d');
        this.resize();
        this.createParticles();
        this.addEventListeners();
        this.animate();
    }

    /**
     * Resize canvas to fit window
     */
    resize() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }

    /**
     * Create initial particles
     */
    createParticles() {
        this.particles = [];
        for (let i = 0; i < this.config.particleCount; i++) {
            const radius = Math.random() * (this.config.maxRadius - this.config.baseRadius) + this.config.baseRadius;
            const color = this.config.colors[Math.floor(Math.random() * this.config.colors.length)];
            
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: (Math.random() - 0.5) * this.config.baseSpeed * 2,
                vy: (Math.random() - 0.5) * this.config.baseSpeed * 2,
                radius: radius,
                color: color,
                originalRadius: radius,
                alpha: Math.random() * 0.5 + 0.5
            });
        }
    }

    /**
     * Add event listeners for mouse interaction
     */
    addEventListeners() {
        window.addEventListener('resize', () => {
            this.resize();
            this.createParticles();
        });

        document.addEventListener('mousemove', (e) => {
            this.mouse.x = e.x;
            this.mouse.y = e.y;
        });

        document.addEventListener('mouseleave', () => {
            this.mouse.x = null;
            this.mouse.y = null;
        });
    }

    /**
     * Update particle physics
     */
    update() {
        this.particles.forEach(particle => {
            // Zero-gravity: particles float in random direction
            particle.x += particle.vx;
            particle.y += particle.vy;

            // Bounce off edges
            if (particle.x < 0 || particle.x > this.canvas.width) {
                particle.vx = -particle.vx;
            }
            if (particle.y < 0 || particle.y > this.canvas.height) {
                particle.vy = -particle.vy;
            }

            // Keep particles within bounds
            particle.x = Math.max(particle.radius, Math.min(this.canvas.width - particle.radius, particle.x));
            particle.y = Math.max(particle.radius, Math.min(this.canvas.height - particle.radius, particle.y));

            // Mouse interaction - repulsion
            if (this.mouse.x !== null && this.mouse.y !== null) {
                const dx = particle.x - this.mouse.x;
                const dy = particle.y - this.mouse.y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < this.config.mouseRadius) {
                    // Calculate repulsion force
                    const force = (this.config.mouseRadius - distance) / this.config.mouseRadius;
                    const angle = Math.atan2(dy, dx);
                    
                    // Apply acceleration away from mouse
                    particle.vx += Math.cos(angle) * force * this.config.acceleration * 5;
                    particle.vy += Math.sin(angle) * force * this.config.acceleration * 5;
                    
                    // Increase size near mouse
                    particle.radius = Math.min(particle.originalRadius * 2, particle.radius + 0.2);
                } else {
                    // Return to original size
                    if (particle.radius > particle.originalRadius) {
                        particle.radius -= 0.05;
                    }
                }
            }

            // Apply friction to prevent infinite acceleration
            particle.vx *= this.config.friction;
            particle.vy *= this.config.friction;

            // Minimum speed to keep particles moving (zero-gravity effect)
            const minSpeed = 0.2;
            const currentSpeed = Math.sqrt(particle.vx * particle.vx + particle.vy * particle.vy);
            if (currentSpeed < minSpeed) {
                particle.vx += (Math.random() - 0.5) * 0.1;
                particle.vy += (Math.random() - 0.5) * 0.1;
            }

            // Maximum speed limit
            const maxSpeed = 3;
            if (currentSpeed > maxSpeed) {
                particle.vx = (particle.vx / currentSpeed) * maxSpeed;
                particle.vy = (particle.vy / currentSpeed) * maxSpeed;
            }
        });
    }

    /**
     * Draw particles on canvas
     */
    draw() {
        // Clear canvas with slight fade effect for trail
        this.ctx.fillStyle = 'rgba(15, 23, 42, 0.1)';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);

        // Draw particles
        this.particles.forEach(particle => {
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
            this.ctx.fillStyle = particle.color;
            this.ctx.globalAlpha = particle.alpha;
            this.ctx.fill();
            this.ctx.globalAlpha = 1;
        });

        // Draw connections between nearby particles
        this.drawConnections();
    }

    /**
     * Draw lines between nearby particles
     */
    drawConnections() {
        const maxDistance = 100;
        
        for (let i = 0; i < this.particles.length; i++) {
            for (let j = i + 1; j < this.particles.length; j++) {
                const dx = this.particles[i].x - this.particles[j].x;
                const dy = this.particles[i].y - this.particles[j].y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < maxDistance) {
                    const opacity = 1 - (distance / maxDistance);
                    this.ctx.beginPath();
                    this.ctx.moveTo(this.particles[i].x, this.particles[i].y);
                    this.ctx.lineTo(this.particles[j].x, this.particles[j].y);
                    this.ctx.strokeStyle = `rgba(239, 68, 68, ${opacity * 0.2})`;
                    this.ctx.lineWidth = 0.5;
                    this.ctx.stroke();
                }
            }
        }
    }

    /**
     * Animation loop
     */
    animate() {
        this.update();
        this.draw();
        this.animationId = requestAnimationFrame(() => this.animate());
    }

    /**
     * Stop animation
     */
    stop() {
        if (this.animationId) {
            cancelAnimationFrame(this.animationId);
        }
    }

    /**
     * Destroy particle system
     */
    destroy() {
        this.stop();
        if (this.canvas && this.canvas.parentNode) {
            this.canvas.parentNode.removeChild(this.canvas);
        }
    }
}

// Auto-initialize when DOM is ready
if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            const particleSystem = new ParticleSystem();
            particleSystem.init();
            window.particleSystem = particleSystem;
        });
    } else {
        const particleSystem = new ParticleSystem();
        particleSystem.init();
        window.particleSystem = particleSystem;
    }
}

// Export for ES6 modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ParticleSystem;
}