<html>
<style>
    .error-container {
        display: fixed;
        position: absolute;
        top: 10%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #eee6f3;
        color: #9163CB;
        border: 1px solid #9163CB;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.7);
        display: none;
        width: 80%;
        max-width: 400px;
        z-index: 1000;
        overflow: hidden;
        opacity: 0;
        animation: fadeIn 2s linear;

        & p {
            font: bold 1.2em Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
    }

    .progress-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 5px;
        background-color: #A06CD5;
        /* Cor da barra de progresso */
        width: 100%;
        animation: progress 2s linear;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        5% {
            opacity: 1;
        }

        95% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }

    @keyframes progress {
        0% {
            width: 100%;
        }

        100% {
            width: 0%;
        }
    }
</style>
<div class="error-container" id="error-container">
    <p><?= htmlspecialchars($_SESSION['resposta']) ?></p>
    <div class="progress-bar" id="progress-bar"></div>
</div>

<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessage = "<?php echo isset($_SESSION['resposta']) ? $_SESSION['resposta'] : ''; ?>";
        if (errorMessage !== '') {
            var errorContainer = document.getElementById('error-container');
            errorContainer.style.display = 'block';
            var timeoutId = setTimeout(function() {
                errorContainer.style.display = 'none';
                clearTimeout(timeoutId);
            }, 2000);

            document.addEventListener('click', cancelTimeout);

            function cancelTimeout() {
                clearTimeout(timeoutId);
                errorContainer.style.display = 'none';
                document.removeEventListener('click', cancelTimeout);
            }
        }
    });
</script>
<?php
unset($_SESSION['resposta']);
?>

</html>