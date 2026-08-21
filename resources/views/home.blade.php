@extends('layouts.app')
@section('content')

<style>
*{ box-sizing: border-box; }
body { margin: 0; background: #FFF6F4; font-family: 'Poppins', Arial, sans-serif; color: #1f1f1f; }
.birthday-dashboard { min-height: calc(100vh - 56px); display: flex; background: #FFF6F4; }
.sidebar { width: 195px; min-height: calc(100vh - 56px); padding: 20px 16px; display: flex; flex-direction: column; flex-shrink: 0; background: #FFE1DD; }
.brand { margin-bottom: 20px; text-align: center; }
.brand-icon { width: 58px; height: 58px; margin: 0 auto 8px; position: relative; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #FFC6BE, #FF9E9E); border-radius: 50%; box-shadow: 0 6px 12px rgba(255, 130, 120, 0.35); font-size: 28px; }
.brand h1 { margin: 0; color: #2a2a2a; font-size: 14px; font-weight: 800; letter-spacing: 0.2px; line-height: 1.2; }
.menu { display: flex; flex-direction: column; gap: 3px; }
.menu a { display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #4a4a4a; font-size: 11px; font-weight: 500; text-decoration: none; border-radius: 8px; transition: 0.2s; }
.menu a:hover, .menu a.active { background: #FFB98A; color: #7a3a10; font-weight: 700; box-shadow: 0 3px 8px rgba(255, 150, 90, 0.35); }
.menu-icon { width: 16px; text-align: center; font-size: 12px; }
.sidebar-decoration { margin-top: auto; text-align: center; font-size: 34px; opacity: 0.9; }
.main-content { flex: 1; min-width: 0; background: #FFF6F4; }
.dashboard-wrapper { padding: 18px 26px 0; }
.dashboard-wrapper + .dashboard-wrapper { padding-top: 0; }
.topbar { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 10px; }
.search-box { width: 260px; height: 32px; display: flex; align-items: center; padding: 0 12px; background: #fff; border: none; border-radius: 20px; box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06); }
.search-box span { margin-right: 6px; color: #b58f86; font-size: 13px; }
.search-box input { width: 100%; border: none; outline: none; background: transparent; font-size: 10.5px; }
.search-box input::placeholder { color: #b58f86; }
.user-area { display: flex; align-items: center; gap: 12px; }
.notification { width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: #333; font-size: 14px; background: #fff; border-radius: 50%; box-shadow: 0 3px 7px rgba(0, 0, 0, 0.06); }
.user-profile { display: flex; align-items: center; gap: 6px; }
.user-avatar { width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; background: #FFCF9D; border: 2px solid #fff; border-radius: 50%; box-shadow: 0 3px 7px rgba(0, 0, 0, 0.08); font-size: 14px; }
.user-name { font-size: 11px; font-weight: 700; }
.welcome-section { position: relative; min-height: 88px; display: flex; align-items: center; justify-content: space-between; padding: 4px 22px 4px 2px; margin-bottom: 10px; overflow: hidden; }
.welcome-text h2 { margin: 0 0 3px; font-size: 21px; font-weight: 800; }
.welcome-text p { max-width: 250px; margin: 0; font-size: 10px; line-height: 1.5; color: #5a5a5a; }
.cake-decoration-wrap { position: relative; width: 100px; height: 78px; flex-shrink: 0; }
.cake-blob { position: absolute; inset: 0; background: linear-gradient(135deg, #FFD3CE, #FFC0CB); border-radius: 62% 38% 45% 55% / 55% 45% 55% 45%; }
.cake-decoration { position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; height: 100%; font-size: 40px; }
.birthday-area { display: grid; grid-template-columns: 175px 1fr; gap: 10px; margin-bottom: 10px; }
.today-card { min-height: 148px; padding: 10px; text-align: center; background: linear-gradient(160deg, #E89A66, #D97F49); border-radius: 14px; box-shadow: 0 8px 18px rgba(216, 128, 74, 0.35); }
.card-title { margin-bottom: 4px; color: #fff; font-size: 9px; font-weight: 600; }
.birthday-avatar { width: 50px; height: 50px; margin: 0 auto 4px; display: flex; align-items: center; justify-content: center; background: #FFEDED; border: 2px solid #fff; border-radius: 50%; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15); font-size: 24px; overflow: hidden; }
.today-card h3 { margin: 2px 0 0; color: #fff; font-size: 11.5px; font-weight: 700; }
.today-card p { margin: 0; color: #ffe8d9; font-size: 8px; }
.today-buttons { display: flex; justify-content: center; gap: 4px; margin-top: 6px; }
.love-btn, .calendar-btn { padding: 5px 9px; background: #fff; color: #B3541E; border: none; border-radius: 16px; box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12); font-size: 7.5px; font-weight: 700; cursor: pointer; }
.calendar-btn { padding: 5px 8px; background: #FFEDED; }
.upcoming-card { min-height: 148px; background: #fff; border-radius: 14px; box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06); overflow: hidden; }
.upcoming-header { padding: 7px 14px; background: #C08A63; color: #fff; font-size: 9.5px; font-weight: 700; }
.upcoming-list { padding: 0 14px; }
.upcoming-item { display: flex; align-items: center; justify-content: space-between; padding: 5px 0; border-bottom: 1px solid #f2ece9; }
.upcoming-item:last-child { border-bottom: none; }
.friend-info { display: flex; align-items: center; gap: 8px; }
.friend-avatar { width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; background: #FFE1DD; border-radius: 50%; font-size: 13px; }
.friend-name { font-size: 9px; font-weight: 700; }
.friend-date { margin-top: 1px; color: #8a8a8a; font-size: 7px; }
.days-left { padding: 3px 8px; color: #8a5a3a; font-size: 7px; font-weight: 600; background: #FFF1E6; border-radius: 10px; white-space: nowrap; }
.statistics { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin: 0 0 18px; padding: 14px 20px; background: #fff; border-radius: 14px; box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06); }
.stat-card { display: flex; align-items: center; gap: 8px; }
.stat-icon { width: 36px; height: 36px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border-radius: 9px; font-size: 16px; }
.stat-card:nth-child(1) .stat-icon { background: #E7DEFF; }
.stat-card:nth-child(2) .stat-icon { background: #D6ECFF; }
.stat-card:nth-child(3) .stat-icon { background: #D6F5EE; }
.stat-card:nth-child(4) .stat-icon { background: #FFE3D6; }
.stat-info p { margin: 0; color: #8a8a8a; font-size: 8px; }
.stat-info h3 { margin: 1px 0; font-size: 16px; font-weight: 800; }
.stat-info span { color: #8a8a8a; font-size: 7px; }
@media (max-width: 900px) { .sidebar { width: 170px; } .birthday-area { grid-template-columns: 1fr; } .statistics { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 650px) { .birthday-dashboard { flex-direction: column; } .sidebar { width: 100%; min-height: auto; } .brand { margin-bottom: 12px; } .menu { flex-direction: row; flex-wrap: wrap; } .sidebar-decoration { display: none; } .topbar { flex-direction: column; align-items: stretch; } .search-box { width: 100%; } .welcome-section { flex-direction: column; text-align: center; } .statistics { grid-template-columns: 1fr 1fr; padding: 14px; } }
</style>