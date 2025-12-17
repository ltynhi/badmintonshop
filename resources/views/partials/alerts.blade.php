@if(session('success'))
    <div id="successAlert" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 20px; text-align: center; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); position: relative; z-index: 1000; transition: all 0.5s ease;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: center; gap: 15px; position: relative;">
            <span style="font-size: 2rem;">✓</span>
            <div style="text-align: left; flex: 1;">
                <div style="font-size: 1.2rem; font-weight: bold; margin-bottom: 5px;">Thành công!</div>
                <div style="font-size: 1rem;">{{ session('success') }}</div>
            </div>
            <button onclick="closeAlert('successAlert')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.3); border: none; color: white; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; font-size: 1.2rem; line-height: 1; transition: all 0.3s ease;">×</button>
        </div>
    </div>
@endif

@if(session('error'))
    <div id="errorAlert" style="background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%); color: white; padding: 20px; text-align: center; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3); position: relative; z-index: 1000; transition: all 0.5s ease;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: center; gap: 15px; position: relative;">
            <span style="font-size: 2rem;">✗</span>
            <div style="text-align: left; flex: 1;">
                <div style="font-size: 1.2rem; font-weight: bold; margin-bottom: 5px;">Lỗi!</div>
                <div style="font-size: 1rem;">{{ session('error') }}</div>
            </div>
            <button onclick="closeAlert('errorAlert')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.3); border: none; color: white; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; font-size: 1.2rem; line-height: 1; transition: all 0.3s ease;">×</button>
        </div>
    </div>
@endif

<script>
    function closeAlert(id) {
        const alert = document.getElementById(id);
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => alert.remove(), 500);
        }
    }

    // Tự động ẩn sau 5 giây
    setTimeout(() => {
        closeAlert('successAlert');
        closeAlert('errorAlert');
    }, 5000);
</script>
