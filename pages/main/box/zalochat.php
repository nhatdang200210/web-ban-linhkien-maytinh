<button title="Zalo" id="nutzalo">ZALO</button>

<style>
    #nutzalo {
        border: none;
        border-radius: 100%;
        width: 50px;
        height: 50px;
        background: #0065f7;
        color: #fff;
        font-weight: bold;
        position: fixed;
        display: grid;
        align-items: center;
        text-align: center;
        font-size: 12px;
        padding: 0px;
        bottom: 60px;
        /* margin-bottom: 50px; */
        right: 25px;
        animation: zalo 1000ms infinite;
        z-index: 999999999;
    }

    #nutzalo:hover {
        opacity: 0.6;
    }

    @keyframes zalo {
        0% {
            transform: translate3d(0, 0, 0) scale(1);
        }

        33.3333% {
            transform: translate3d(0, 0, 0) scale(0.9);
        }

        66.6666% {
            transform: translate3d(0, 0, 0) scale(1);
        }

        100% {
            transform: translate3d(0, 0, 0) scale(1);
        }

        0% {
            box-shadow: 0 0 0 0px #0065f7, 0 0 0 0px #0065f7;
        }

        50% {
            transform: scale(0.8);
        }

        100% {
            box-shadow: 0 0 0 15px rgba(0, 210, 255, 0), 0 0 0 30px rgba(0, 210, 255, 0);
        }
    }
</style>
<script>
    function isMobileDevice() {
        return /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    }
    const nutzalo = document.getElementById('nutzalo');

    function ZaloClick() {
        let link;
        if (isMobileDevice()) {
            if (navigator.userAgent.includes('Android')) {
                // android	
                link = 'https://zaloapp.com/qr/p/1u9wrtaygn35z';
                // với link này để mở zalo điện thoại anh em chỉ cần vào cá nhân / lấy "Mã QR của tôi" sau đó lưu mã lấy đt quét mã đó rồi copy link ở trình duyệt 
            } else {
                // ios
                link = 'zalo://qr/p/1u9wrtaygn35z';
                // lấy đoạn link phía sau
            }
        } else {
            // link mở zalo pc
            link = 'zalo://conversation?phone=0842775549';
            // với link này để mở zalo pc chỉ cần thay sđt zalo 
        }
        window.open(link, '_blank');
    }
    nutzalo.addEventListener('click', ZaloClick);
</script>