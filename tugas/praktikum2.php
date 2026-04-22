<?php
// --- STRUKTUR CODE PERTAMA (TETAP TERJAGA) ---
class Matematika {
    public static function kali($a, $b) { return $a * $b; }
    public static function bagi($a, $b) { return ($b != 0) ? $a / $b : "ERROR_SYS"; }
    public static function tambah($a, $b) { return $a + $b; }
    public static function kurang($a, $b) { return $a - $b; }
    public static function persegi($a, $b) { return $a * $a; }
}

$hasil = null;
// Memastikan input tetap kosong sebelum ada aksi
$n1_val = isset($_POST['n1']) ? $_POST['n1'] : "";
$n2_val = isset($_POST['n2']) ? $_POST['n2'] : "";

if (isset($_POST['op'])) {
    $n1 = ($n1_val !== "") ? (float)$n1_val : 0;
    $n2 = ($n2_val !== "") ? (float)$n2_val : 0;
    $op = $_POST['op'];

    if ($op == "kali") $hasil = Matematika::kali($n1, $n2);
    if ($op == "bagi") $hasil = Matematika::bagi($n1, $n2);
    if ($op == "tambah") $hasil = Matematika::tambah($n1, $n2);
    if ($op == "kurang") $hasil = Matematika::kurang($n1, $n2);
    if ($op == "persegi") $hasil = Matematika::persegi($n1, $n1);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>KALKULATOR TEC | ROBOTIC INTERFACE</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-cyan: #00f2ff;
            --neon-purple: #bc13fe;
            --glass-bg: rgba(6, 11, 25, 0.85);
        }

        body, html {
            margin: 0; padding: 0; height: 100%; width: 100%;
            background: #010409;
            font-family: 'Rajdhani', sans-serif;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Latar Belakang Animasi Canvas */
        canvas {
            position: absolute;
            top: 0; left: 0;
            z-index: 1;
        }

        /* Panel Utama */
        .robot-frame {
            position: relative;
            z-index: 10;
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 242, 255, 0.3);
            border-radius: 20px;
            padding: 45px;
            width: 380px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.8), inset 0 0 20px rgba(0, 242, 255, 0.1);
        }

        /* Elemen Dekorasi Robotik di Sudut */
        .robot-frame::before {
            content: "CORE_v3.2";
            position: absolute;
            top: -10px; right: 20px;
            background: var(--neon-cyan);
            color: black;
            font-family: 'Orbitron';
            font-size: 8px;
            padding: 2px 8px;
            border-radius: 4px;
        }

        h2 {
            font-family: 'Orbitron', sans-serif;
            text-align: center;
            font-size: 1.5rem;
            letter-spacing: 6px;
            margin-bottom: 40px;
            color: white;
            text-shadow: 0 0 15px var(--neon-cyan);
        }

        .input-group { margin-bottom: 25px; }

        label {
            font-size: 10px;
            color: var(--neon-cyan);
            letter-spacing: 2px;
            display: block;
            margin-bottom: 8px;
            opacity: 0.8;
        }

        input {
            width: 100%;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 16px;
            border-radius: 12px;
            color: var(--neon-cyan);
            font-family: 'Orbitron', sans-serif;
            font-size: 1.2rem;
            text-align: center;
            outline: none;
            box-sizing: border-box;
            transition: 0.3s;
        }

        input:focus {
            border-color: var(--neon-cyan);
            background: rgba(0, 242, 255, 0.05);
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.3);
        }

        /* Grid Tombol Berwarna */
        .grid-action {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(0, 242, 255, 0.4);
            color: var(--neon-cyan);
            padding: 15px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 10px;
            font-family: 'Rajdhani';
            text-transform: uppercase;
            transition: 0.3s;
        }

        .btn:hover {
            background: var(--neon-cyan);
            color: black;
            box-shadow: 0 0 25px var(--neon-cyan);
            transform: translateY(-2px);
        }

        .btn-purple {
            grid-column: span 2;
            border-color: var(--neon-purple);
            color: var(--neon-purple);
            font-family: 'Orbitron';
            font-size: 0.8rem;
        }

        .btn-purple:hover {
            background: var(--neon-purple);
            color: white;
            box-shadow: 0 0 25px var(--neon-purple);
        }

        /* Panel Hasil Digital */
        .result-screen {
            margin-top: 35px;
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .res-label { font-size: 9px; color: #555; display: block; margin-bottom: 5px; }
        .res-val { font-size: 2.5rem; font-weight: bold; color: white; text-shadow: 0 0 10px white; }

    </style>
</head>
<body>

<canvas id="canvas"></canvas>

<div class="robot-frame">
    <h2>KALKULATOR TEC</h2>
    
    <form method="POST">
        <div class="input-group">
            <label>MASUKKAN ANGKA 1</label>
            <input type="number" name="n1" step="any" placeholder="---" value="<?= htmlspecialchars($n1_val) ?>">
        </div>

        <div class="input-group">
            <label>MASUKKAN ANGKA 2</label>
            <input type="number" name="n2" step="any" placeholder="---" value="<?= htmlspecialchars($n2_val) ?>">
        </div>

        <div class="grid-action">
            <button type="submit" name="op" value="tambah" class="btn" onmousedown="synthSound(880)">TAMBAH (+)</button>
            <button type="submit" name="op" value="kurang" class="btn" onmousedown="synthSound(780)">KURANG (-)</button>
            <button type="submit" name="op" value="kali" class="btn" onmousedown="synthSound(680)">KALI (×)</button>
            <button type="submit" name="op" value="bagi" class="btn" onmousedown="synthSound(580)">BAGI (÷)</button>
            <button type="submit" name="op" value="persegi" class="btn btn-purple" onmousedown="synthSound(440)">HITUNG LUAS PERSEGI (S²)</button>
        </div>
    </form>

    <?php if ($hasil !== null): ?>
    <div class="result-screen">
        <span class="res-label">DATA_ANALYSIS_COMPLETE</span>
        <span class="res-val"><?= $hasil ?></span>
    </div>
    <?php endif; ?>
</div>

<script>
    // --- ANIMASI LATAR BELAKANG TEKNOLOGI (Nodes & Lines) ---
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    let particles = [];

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    window.addEventListener('resize', resize);
    resize();

    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 2 + 1;
            this.speedX = Math.random() * 1 - 0.5;
            this.speedY = Math.random() * 1 - 0.5;
            this.color = Math.random() > 0.5 ? '#00f2ff' : '#bc13fe';
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            if (this.x > canvas.width) this.x = 0;
            if (this.x < 0) this.x = canvas.width;
            if (this.y > canvas.height) this.y = 0;
            if (this.y < 0) this.y = canvas.height;
        }
        draw() {
            ctx.fillStyle = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    function init() {
        for (let i = 0; i < 100; i++) {
            particles.push(new Particle());
        }
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
            // Gambar garis antar partikel (Efek Jaringan Robot)
            for (let j = i; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                if (distance < 100) {
                    ctx.strokeStyle = particles[i].color;
                    ctx.globalAlpha = 1 - (distance / 100);
                    ctx.lineWidth = 0.5;
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
        ctx.globalAlpha = 1;
        requestAnimationFrame(animate);
    }

    // --- EFEK SUARA TEKNOLOGI ---
    function synthSound(freq) {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();

        oscillator.type = 'square'; 
        oscillator.frequency.setValueAtTime(freq, audioCtx.currentTime);
        oscillator.frequency.exponentialRampToValueAtTime(10, audioCtx.currentTime + 0.1);
        
        gainNode.gain.setValueAtTime(0.05, audioCtx.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.1);

        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);
        oscillator.start();
        oscillator.stop(audioCtx.currentTime + 0.1);
    }

    init();
    animate();
</script>

</body>
</html>