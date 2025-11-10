@extends('layouts.frontend')

@section('title', 'LCM Investigation — Enquêter, révéler, comprendre')

@section('content')
    <style>
        /* Fix global pour éviter le scroll horizontal */
        html, body {
            overflow-x: hidden !important;
            max-width: 100vw !important;
        }

        ol, ul, menu {
            all: revert;
        }

        :root {
            --ink: #0e1116;
            --blue: #0B2B5A;
            --blue-2: #143F86;
            --blue-3: #1E56B3;
            --blue-light: #2563eb;
            --sky: #E8F1FF;
            --sky-soft: #F0F6FF;
            --accent: #FFC940;
            --bg: #F7F9FC;
            --bg-soft: #FAFCFE;
            --card: #FFFFFF;
            --muted: #5E6B7A;
            --line: #E5EDF6;
            --green: #1FA37B;
            --red: #D04A4A;
            --warn: #B97400;
            --radius: 14px;
            --shadow: 0 6px 22px rgba(10, 35, 80, .08);
            --shadow-sm: 0 4px 14px rgba(10, 35, 80, .06);
            --shadow-hover: 0 12px 32px rgba(10, 35, 80, .15);
            --focus: 0 0 0 4px rgba(30, 86, 179, .18);
        }

        * {
            box-sizing: border-box
        }

        html, body {
            overflow-x: hidden;
            max-width: 100vw;
        }

        img {
            max-width: 100%;
            display: block
        }

        .container {
            margin: 0 auto;
        }

        /* Topbar avec animation */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: linear-gradient(180deg, #fafcfe, #f8fbff);
            border-bottom: 1px solid var(--line);
            padding-top: 5px;
            transition: all 0.3s ease;
        }

        .topbar:hover {
            box-shadow: 0 4px 16px rgba(10, 35, 80, 0.1);
        }

        .topbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px
        }

        /* Brand avec animation */
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .brand:hover {
            transform: translateX(5px);
        }

        .logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--blue), var(--blue-2));
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 900;
            letter-spacing: .5px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .brand:hover .logo {
            transform: rotate(360deg) scale(1.1);
            box-shadow: 0 4px 12px rgba(11, 43, 90, 0.3);
        }

        .brand-title {
            font-weight: 900;
            letter-spacing: .2px;
            transition: color 0.3s ease;
        }

        .brand:hover .brand-title {
            color: var(--blue-3);
        }

        /* Tags avec animation */
        .tag {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 999px;
            background: var(--sky);
            color: var(--blue-2);
            border: 1px solid var(--line);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tag:hover {
            background: var(--blue-3);
            color: white;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 4px 12px rgba(30, 86, 179, 0.2);
        }

        /* Boutons avec animations avancées */
        .btn {
            border: 0;
            border-radius: 12px;
            padding: 12px 16px;
            font-weight: 800;
            letter-spacing: .2px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn.primary {
            background: var(--blue-3);
            color: #fff;
            box-shadow: var(--shadow-sm);
        }

        .btn.primary:hover {
            background: var(--blue-2);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 20px rgba(30, 86, 179, 0.3);
        }

        .btn.secondary {
            background: #fff;
            color: var(--blue-3);
            border: 2px solid var(--blue-3);
        }

        .btn.secondary:hover {
            background: var(--blue-3);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(30, 86, 179, 0.2);
        }

        .btn.warn {
            background: var(--accent);
            color: #5a3d00;
        }

        .btn.warn:hover {
            background: #ffdb70;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 6px 16px rgba(255, 201, 64, 0.3);
        }

        .btn.ghost {
            background: #fff;
            border: 2px solid var(--line);
            color: var(--blue);
        }

        .btn.ghost:hover {
            background: var(--sky-soft);
            border-color: var(--blue-3);
            transform: translateY(-2px);
        }

        .btn:focus {
            outline: none;
            box-shadow: var(--focus)
        }

        /* Hero avec animation */
        .hero {
            padding: 20px 0 28px;
            background: linear-gradient(180deg, #fafcfe, #f0f6ff);
            border-bottom: 1px solid var(--line);
            transition: all 0.4s ease;
        }

        .hero:hover {
            background: linear-gradient(180deg, #ffffff, #f5f9ff);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(10, 35, 80, 0.08);
        }

        .hero h1 {
            font-size: 42px;
            line-height: 1.15;
            margin: 8px 0 10px;
            transition: all 0.3s ease;
        }

        .hero:hover h1 {
            color: var(--blue-3);
            transform: scale(1.02);
        }

        .hero p {
            max-width: 860px;
            color: var(--muted);
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .hero:hover p {
            color: var(--ink);
        }

        .badges {
            margin-top: 14px
        }

        /* Pills avec animation */
        .pill {
            padding: 6px 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, #F0F6FF, #E8F1FF);
            border: 1px solid var(--line);
            font-size: 12px;
            color: #223a67;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-block;
        }

        .pill:hover {
            background: var(--blue-3);
            color: white;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 4px 12px rgba(30, 86, 179, 0.2);
        }

        /* Subnav avec animation */
        .subnav {
            position: sticky;
            top: 68px;
            z-index: 19;
            background: linear-gradient(180deg, #ffffff, #fafcfe);
            border-bottom: 1px solid var(--line);
            transition: all 0.3s ease;
        }

        .subnav:hover {
            box-shadow: 0 4px 12px rgba(10, 35, 80, 0.08);
        }

        .subnav .container {
            padding: 10px 0;
        }

        /* Tabs avec animation */
        .tab {
            padding: 10px 14px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--line);
            cursor: pointer;
            font-weight: 700;
            color: #223a67;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .tab::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(30, 86, 179, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .tab:hover::before {
            left: 100%;
        }

        .tab:hover {
            background: var(--sky-soft);
            border-color: var(--blue-3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 86, 179, 0.15);
        }

        .tab.active {
            background: var(--blue-3);
            border-color: var(--blue-3);
            color: #fff;
            box-shadow: 0 4px 12px rgba(30, 86, 179, 0.25);
        }

        .tab.active:hover {
            transform: translateY(-3px) scale(1.02);
        }

        .section {
            display: none;
            padding: 26px 0;
        }

        .section.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #projectGrid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 18px;
        }

        /* Cartes avec animations avancées */
        .card {
            grid-column: span 4;
            background: linear-gradient(135deg, #ffffff 0%, #fafcfe 100%);
            border: 1px solid var(--line);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--blue), var(--blue-3));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-hover);
            border-color: var(--blue-3);
            background: linear-gradient(135deg, #ffffff 0%, #f5f9ff 100%);
        }

        .card .media {
            height: 150px;
            background: linear-gradient(135deg, #dfe9ff, #f0f6ff);
            display: grid;
            place-items: center;
            color: #6d7c90;
            font-weight: 800;
            transition: all 0.4s ease;
        }

        .card:hover .media {
            transform: scale(1.05);
            background: linear-gradient(135deg, #d0e2ff, #e8f1ff);
        }

        .card .content {
            padding: 14px
        }

        /* Meta avec animation */
        .meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #6b778a;
            font-size: 12px;
            margin-bottom: 6px
        }

        /* Status avec animation */
        .status {
            font-size: 12px;
            font-weight: 900;
            padding: 4px 8px;
            border-radius: 999px;
            transition: all 0.3s ease;
        }

        .status.pending {
            color: var(--warn);
            background: #fff3e6;
        }

        .card:hover .status.pending {
            background: var(--warn);
            color: white;
            transform: scale(1.05);
        }

        .status.validated {
            color: var(--green);
            background: #e8f5f0;
        }

        .card:hover .status.validated {
            background: var(--green);
            color: white;
            transform: scale(1.05);
        }

        .status.rejected {
            color: var(--red);
            background: #fee;
        }

        .card:hover .status.rejected {
            background: var(--red);
            color: white;
            transform: scale(1.05);
        }

        .status.in_progress {
            color: var(--blue-3);
            background: var(--sky);
        }

        .card:hover .status.in_progress {
            background: var(--blue-3);
            color: white;
            transform: scale(1.05);
        }

        .status.completed {
            color: var(--green);
            background: #e8f5f0;
        }

        .card:hover .status.completed {
            background: var(--green);
            color: white;
            transform: scale(1.05);
        }

        /* Progress bar avec animation */
        .progress {
            height: 8px;
            background: #edf3ff;
            border-radius: 999px;
            overflow: hidden;
            margin-top: 8px;
            transition: all 0.3s ease;
        }

        .card:hover .progress {
            transform: scaleY(1.2);
            box-shadow: 0 2px 8px rgba(30, 86, 179, 0.2);
        }

        .progress>div {
            height: 8px;
            background: linear-gradient(90deg, var(--accent), #ffe487);
            width: 0%;
            transition: width 0.6s ease;
        }

        /* Panel avec animation */
        .panel {
            background: linear-gradient(135deg, #fafcfe 0%, #f5f9ff 100%);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .panel:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(30, 86, 179, 0.2);
            background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        }

        .panel header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--line);
            font-weight: 900;
            color: #143F86;
            transition: all 0.3s ease;
        }

        .panel:hover header {
            color: var(--blue-3);
            background: var(--sky-soft);
        }

        .panel .body {
            padding: 16px;
        }

        /* KPIs avec animation */
        .kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .kpi {
            background: linear-gradient(135deg, #ffffff, #fafcfe);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
            box-shadow: var(--shadow-sm);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
        }

        .kpi:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 8px 24px rgba(30, 86, 179, 0.15);
            border-color: var(--blue-3);
            background: linear-gradient(135deg, #ffffff, #f0f6ff);
        }

        .kpi .v {
            font-size: 26px;
            font-weight: 900;
            color: var(--blue-3);
            transition: all 0.3s ease;
        }

        .kpi:hover .v {
            transform: scale(1.1);
            color: var(--blue-light);
        }

        .legend {
            font-size: 12px;
            color: #6b7688
        }

        /* Liste items avec animation */
        .list .item {
            border: 1px dashed var(--line);
            border-radius: 12px;
            padding: 12px;
            margin: 10px 0;
            background: linear-gradient(135deg, #fbfdff, #f8fbff);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .list .item:hover {
            transform: translateX(10px);
            box-shadow: 0 4px 16px rgba(10, 35, 80, 0.1);
            border-color: var(--blue-3);
            border-style: solid;
            background: white;
        }

        /* Formulaire avec animations */
        .form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px
        }

        .label {
            font-size: 13px;
            color: #2d3b52;
            font-weight: 700
        }

        .control {
            position: relative
        }

        .input,
        .select,
        .textarea {
            width: 100%;
            border: 1.6px solid #cfdef3;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            background: #fff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input:hover,
        .select:hover,
        .textarea:hover {
            border-color: var(--blue-3);
            box-shadow: 0 2px 8px rgba(30, 86, 179, 0.08);
            transform: translateY(-2px);
        }

        .input:focus,
        .select:focus,
        .textarea:focus {
            border-color: var(--blue-3);
            box-shadow: var(--focus);
            outline: none;
            transform: translateY(-2px);
        }

        .textarea {
            min-height: 130px;
            resize: vertical
        }

        .hint {
            font-size: 12px;
            color: #6b7688
        }

        .error {
            color: var(--red);
            font-size: 12px;
            display: none
        }

        .invalid .input,
        .invalid .textarea,
        .invalid .select {
            border-color: var(--red)
        }

        .invalid .error {
            display: block
        }

        .counter {
            position: absolute;
            right: 12px;
            bottom: -18px;
            font-size: 12px;
            color: #6b7688
        }

        /* Upload zone avec animation */
        .upload {
            border: 2px dashed #cfe0ff;
            border-radius: 14px;
            padding: 18px;
            text-align: center;
            background: linear-gradient(135deg, #f5f9ff, #f0f6ff);
            color: #4a5b77;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .upload:hover {
            background: linear-gradient(135deg, #e8f1ff, #dfe9ff);
            border-color: var(--blue-3);
            transform: scale(1.02);
            box-shadow: 0 4px 16px rgba(30, 86, 179, 0.12);
        }

        .upload.drag {
            background: linear-gradient(135deg, #e8f1ff, #d0e2ff);
            border-color: var(--blue-3);
            border-style: solid;
            transform: scale(1.05);
        }

        .upload input {
            display: none
        }

        .divider {
            height: 1px;
            background: var(--line);
            margin: 14px 0
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
            margin-top: 6px
        }

        /* Modal avec animation */
        .modal {
            position: fixed;
            inset: 0;
            display: none;
            background: rgba(13, 23, 41, .5);
            align-items: center;
            justify-content: center;
            padding: 18px;
            z-index: 50;
            backdrop-filter: blur(4px);
        }

        .modal.open {
            display: flex;
            animation: fadeInModal 0.3s ease;
        }

        @keyframes fadeInModal {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal .box {
            background: #fff;
            border-radius: 16px;
            max-width: 940px;
            width: 100%;
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: slideUpModal 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideUpModal {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal header {
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            gap: 10px
        }

        .modal .content {
            padding: 16px
        }

        /* Responsive */
        @media (max-width:980px) {
            .grid .card {
                grid-column: span 6
            }

            .form {
                grid-template-columns: 1fr
            }

            .kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width:600px) {
            .grid .card {
                grid-column: span 12
            }

            .kpis {
                grid-template-columns: 1fr;
            }
        }

        /* Conteneur de notifications avec animation */
        #notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
        }

        /* Style des alertes avec animation */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease-out;
            transition: all 0.3s ease;
        }

        .alert:hover {
            transform: translateX(-5px) scale(1.02);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .alert-success {
            background-color: #10b981;
            color: white;
            border-left: 4px solid #059669;
        }

        .alert-error {
            background-color: #ef4444;
            color: white;
            border-left: 4px solid #dc2626;
        }

        .alert-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .alert-close:hover {
            opacity: 1;
            transform: rotate(90deg) scale(1.2);
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Modal Guide éditorial avec animation */
        .guide-modal {
            position: fixed;
            inset: 0;
            display: none;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 9999;
            backdrop-filter: blur(4px);
        }

        .guide-modal.open {
            display: flex;
            animation: fadeInModal 0.3s ease;
        }

        .guide-modal-container {
            background: white;
            border-radius: 16px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            animation: slideUpModal 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .guide-modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, var(--sky-soft), var(--sky));
        }

        .guide-modal-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--blue);
        }

        .guide-modal-body {
            padding: 20px 20px 24px;
            overflow-y: auto;
            background: var(--bg-soft);
        }

        .guide-section {
            margin-bottom: 24px;
            background: white;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid var(--line);
            transition: all 0.3s ease;
        }

        .guide-section:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(10, 35, 80, 0.1);
            border-color: var(--blue-3);
        }

        .guide-section:last-child {
            margin-bottom: 0;
        }

        .guide-section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--blue);
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .guide-section:hover .guide-section-title {
            color: var(--blue-3);
            transform: translateX(5px);
        }

        .guide-list {
            margin: 0;
            padding-left: 24px;
            list-style-position: outside;
        }

        .guide-list li {
            margin-bottom: 8px;
            color: #333;
            line-height: 1.5;
            transition: all 0.3s ease;
        }

        .guide-list li:hover {
            color: var(--blue-3);
            transform: translateX(5px);
        }

        .guide-text {
            color: #333;
            line-height: 1.6;
            margin: 0;
        }

        /* Titre de carte avec animation */
        .card h3 {
            transition: all 0.3s ease;
        }

        .card:hover h3 {
            color: var(--blue-3);
            transform: translateX(5px);
        }

        /* Effets de lumière sur les sections - DÉSACTIVÉ pour éviter le scroll horizontal */
        /* .section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(30, 86, 179, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: drift 20s linear infinite;
            pointer-events: none;
        }

        @keyframes drift {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        } */
    </style>

    <section class="hero">
        <center>
        <div class="container">
            <h1><strong>Le pôle d'enquêtes d'intérêt public de LCM +</strong></h1>
            <p>Cellule dédiée à l'investigation numérique en Afrique francophone. Rédaction interne, pigistes et partenaires
                (ONG, collectifs, citoyens) mènent des enquêtes validées par la direction éditoriale et diffusées en
                <strong>article long</strong>, <strong>vidéo</strong>, <strong>podcast</strong> et
                <strong>infographie</strong>.
            </p>
            <center>
                <div class="badges">
                    <span class="pill">Sources vérifiées</span>
                    <span class="pill">Droit de réponse</span>
                    <span class="pill">Protection des lanceurs</span>
                    <span class="pill">Méthode transparente</span>
                </div>
            </center>
        </div>
        </center>
    </section>

    <div class="subnav">
        <center>
            <div class="container">
                <button class="tab active" data-tab="overview">Présentation</button>
                <button class="tab" data-tab="projects">Enquêtes en cours</button>
                <button class="tab" data-tab="submit">Proposer une enquête</button>
            </div>
        </center>
    </div>

    <!-- Présentation -->
    <section id="overview" class="section active">
        <div class="container">
            <div class="panel" style="margin-bottom:20px">
                <header>Notre mission</header>
                <div class="body">
                    <h3 style="margin:0 0 12px;color:var(--blue);font-size:18px;font-weight:700">Révéler ce que d'autres cachent</h3>
                    <p style="margin-bottom:12px;line-height:1.7">Dans un monde saturé par le désastre de la propagande, les fake news, la désinformation et les scandales étouffés, la frontière entre vérité et mensonge n'a jamais été aussi fragile. Dans un pays où une grande partie des médias défend les intérêts d'une minorité, où la surenchère autoritaire du pouvoir semble ne plus avoir de limites, il devient vital de protéger la liberté d'informer et de restaurer la confiance du public dans le journalisme.</p>
                    <p style="margin-bottom:12px;font-style:italic;line-height:1.7">Parce qu'un peuple sans presse libre, c'est un peuple sans regard sur lui-même.</p>
                    <p style="margin-bottom:12px;line-height:1.7">C'est dans cet esprit que nous avons créé <strong>LCM Investigation</strong> — un média numérique indépendant, animé par la conviction que <strong>la vérité ne se négocie pas</strong>.</p>
                    <p style="line-height:1.7">Portée par une <strong>équipe soudée et passionnée</strong>, complétée par des <strong>journalistes reconnus pour leur intégrité et leur courage</strong>, <strong>LCM Investigation</strong> se consacre à <strong>l'enquête d'intérêt public</strong>, à <strong>l'analyse critique</strong> et à <strong>la révélation des faits que d'autres préfèrent taire</strong>.</p>
                </div>
            </div>

            <div class="panel" style="margin-bottom:20px">
                <header>Notre champ d'action</header>
                <div class="body">
                    <p style="margin-bottom:12px;line-height:1.7">Nos enquêtes s'étendent sur les grands enjeux de notre temps :</p>
                    <ul style="margin:0 0 16px;padding-left:20px;line-height:1.9">
                        <li>la <strong>corruption</strong> et les abus de pouvoir,</li>
                        <li>la <strong>gouvernance</strong> et la transparence publique,</li>
                        <li>l'<strong>écologie</strong> et la crise environnementale,</li>
                        <li>l'<strong>économie</strong> et les inégalités,</li>
                        <li>la <strong>justice</strong>, la <strong>santé</strong>, <strong>éducation</strong>, et les <strong>luttes sociales</strong>,</li>
                        <li>mais aussi l'<strong>égalité des chances</strong>, l'<strong>innovation</strong>, la <strong>géopolitique</strong> et la <strong>culture</strong>.</li>
                    </ul>
                    <p style="line-height:1.7">Nous explorons ces thématiques à travers des <strong>reportages de terrain</strong>, des <strong>chroniques</strong>, des <strong>documentaires</strong>, des <strong>lives</strong> et des <strong>entretiens exclusifs</strong> — accessibles à tous sur nos plateformes numériques.</p>
                </div>
            </div>

            <div class="panel" style="margin-bottom:20px">
                <header>Notre ambition</header>
                <div class="body">
                    <p style="margin-bottom:12px;line-height:1.7">Faire de <strong>LCM Investigation</strong> un acteur majeur du <strong>journalisme d'impact</strong> en Afrique francophone. Nos enquêtes sont conçues non seulement pour informer, mais pour <strong>réveiller les consciences</strong>, <strong>stimuler le débat public</strong> et <strong>inciter à l'action collective</strong>.</p>
                    <p style="margin-bottom:8px;font-style:italic;line-height:1.7">Parce qu'informer, c'est d'abord comprendre.</p>
                    <p style="line-height:1.7">Et comprendre, c'est déjà commencer à agir.</p>
                </div>
            </div>

            <div class="panel">
                <header>Comment nous travaillons</header>
                <div class="body">
                    <p style="margin-bottom:16px;line-height:1.7">LCM Investigation repose sur un modèle <strong>collaboratif et numérique</strong>, associant journalistes permanents, pigistes, collectifs indépendants et citoyens enquêteurs.</p>

                    <ol style="margin:0;padding-left:20px;line-height:1.8">
                        <li style="margin-bottom:14px">
                            <strong>Proposition d'enquête</strong><br>
                            <span style="color:var(--muted);font-size:15px">Journalistes internes, pigistes ou partenaires peuvent soumettre un projet d'enquête.</span>
                        </li>
                        <li style="margin-bottom:14px">
                            <strong>Validation éditoriale</strong><br>
                            <span style="color:var(--muted);font-size:15px">La direction éditoriale évalue chaque sujet selon son <strong>intérêt public</strong>, sa <strong>pertinence</strong> et sa <strong>faisabilité</strong>.</span>
                        </li>
                        <li style="margin-bottom:14px">
                            <strong>Enquête de terrain et vérification</strong><br>
                            <span style="color:var(--muted);font-size:15px">Collecte de preuves, recoupement des sources, travail de terrain et d'analyse documentaire.</span>
                        </li>
                        <li style="margin-bottom:14px">
                            <strong>Production multimédia</strong><br>
                            <span style="color:var(--muted);font-size:15px">Chaque enquête est publiée sous plusieurs formats : <strong>article long</strong>, <strong>vidéo</strong>, <strong>podcast</strong>, <strong>infographie</strong>, <strong>fil social</strong>.</span>
                        </li>
                        <li>
                            <strong>Diffusion & impact</strong><br>
                            <span style="color:var(--muted);font-size:15px">Les enquêtes validées sont diffusées sur <strong>LCM+</strong>, les <strong>réseaux sociaux</strong> et nos <strong>partenaires médias</strong>.</span>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="panel" style="margin-top:20px">
                <header>Nos valeurs</header>
                <div class="body">
                    <ul style="margin:0 0 20px;padding-left:20px;line-height:1.8">
                        <li style="margin-bottom:10px">
                            <strong>Indépendance absolue</strong> : aucune influence politique, commerciale ou institutionnelle.
                        </li>
                        <li style="margin-bottom:10px">
                            <strong>Rigueur et vérification</strong> : chaque information publiée est recoupée, sourcée et validée.
                        </li>
                        <li style="margin-bottom:10px">
                            <strong>Protection des sources</strong> : confidentialité totale garantie par LCM+.
                        </li>
                        <li>
                            <strong>Journalisme d'impact</strong> : nos enquêtes ne s'arrêtent pas à la publication — elles cherchent à changer les choses.
                        </li>
                    </ul>

                    <div style="margin:24px 0;padding:20px;background:var(--sky);border-left:5px solid var(--blue-3);border-radius:8px">
                        <p style="margin:0 0 6px;font-weight:700;font-size:16px;color:var(--blue)">Nous ne faisons pas du bruit.</p>
                        <p style="margin:0;font-weight:700;font-size:16px;color:var(--blue)">Nous faisons la lumière.</p>
                    </div>

                    <div style="margin-top:30px;text-align:center">
                        <p style="font-weight:900;font-size:20px;color:var(--blue);margin-bottom:6px">LCM Investigation</p>
                        <p style="font-style:italic;color:var(--muted);margin-bottom:18px;font-size:15px">Enquêter, révéler, comprendre.</p>
                        <p style="color:var(--muted);margin-bottom:6px;line-height:1.7">Notre équipe et nos partenaires indépendants travaillent chaque jour pour faire émerger la vérité.</p>
                        <p style="color:var(--muted);margin-bottom:20px;line-height:1.8">
                            ✓ Découvrez nos enquêtes exclusives.<br>
                            ✓ Soutenez celles qui comptent.
                        </p>
                        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:20px">
                            <button class="btn primary" onclick="document.querySelector('[data-tab=projects]').click()">Explorer les enquêtes</button>
                            <button class="btn secondary" onclick="document.querySelector('[data-tab=submit]').click()">Proposer une enquête</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enquêtes en cours -->
    <section id="projects" class="section">
        <div class="container">
            <div class="panel">
                <header>Enquêtes en cours de validation ou d'investigation</header>
                <div class="body">
                    <div class="pro grid" id="projectGrid">
                        @forelse($proposals as $proposal)
                            <div class="card">
                                <div class="media">{{ strtoupper(substr($proposal->theme, 0, 1)) }}</div>
                                <div class="content">
                                    <div class="meta">
                                        <span class="pill">{{ $proposal->format }}</span>
                                        <span class="status {{ $proposal->status }}">
                                            @if ($proposal->status === 'pending')
                                                En validation
                                            @elseif($proposal->status === 'validated')
                                                Validé
                                            @elseif($proposal->status === 'in_progress')
                                                En cours
                                            @elseif($proposal->status === 'completed')
                                                Terminé
                                            @else
                                                Rejeté
                                            @endif
                                        </span>
                                    </div>
                                    <h3 style="margin:0 0 6px">{{ $proposal->title }}</h3>
                                    <p class="legend" style="margin:0">{{ Str::limit($proposal->angle, 100) }}</p>

                                    @if ($proposal->budget && $proposal->budget > 0)
                                        <div class="progress">
                                            <div
                                                style="width:{{ min(100, round(($proposal->budget_collected / $proposal->budget) * 100)) }}%">
                                            </div>
                                        </div>
                                        <div class="meta" style="margin-top:6px">
                                            <span class="legend">Objectif
                                                {{ number_format($proposal->budget, 0, ',', ' ') }} FCFA</span>
                                            <span><strong>{{ number_format($proposal->budget_collected, 0, ',', ' ') }}
                                                    FCFA</strong> collectés</span>
                                        </div>
                                    @endif

                                    <div class="actions" style="justify-content:flex-start;margin-top:10px">
                                        <button class="btn secondary"
                                            onclick="showProposalDetails({{ $proposal->id }})">Voir le dossier</button>
                                        @if ($proposal->status === 'validated' || $proposal->status === 'in_progress')
                                            <button class="btn warn"
                                                onclick="supportProposal({{ $proposal->id }})">Soutenir</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="grid-column:span 12;text-align:center;padding:40px">
                                <p class="legend">Aucune enquête en cours pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Proposer une enquête -->
    <section id="submit" class="section">
        <div class="container">
            <div class="panel">
                <header>Proposer une enquête</header>
                <div class="body">
                    <form id="proposalForm" class="form" method="POST" action="{{ route('investigation.submit') }}">
                        @csrf
                        <div id="fName" class="field">
                            <label class="label">Nom & Prénom *</label>
                            <input type="text" name="name" id="aName" class="input"
                                placeholder="Ex. Jean Dupont" required minlength="3" maxlength="120">
                            <span class="error">Nom requis (3-120 caractères)</span>
                        </div>
                        <div id="fEmail" class="field">
                            <label class="label">Email *</label>
                            <input type="email" name="email" id="aEmail" class="input"
                                placeholder="Ex. jean@email.com" required>
                            <span class="error">Email valide requis</span>
                        </div>
                        <div class="field">
                            <label class="label">Téléphone</label>
                            <input type="tel" name="phone" class="input" placeholder="+229 ...">
                        </div>
                        <div class="field">
                            <label class="label">Ville</label>
                            <input type="text" name="city" class="input" placeholder="Ex. Cotonou">
                        </div>
                        <div id="fTitle" class="field" style="grid-column:span 2">
                            <label class="label">Titre de l'enquête (10-140 caractères) *</label>
                            <div class="control">
                                <input type="text" name="title" id="aTitle" class="input"
                                    placeholder="Un titre clair et descriptif" required minlength="10" maxlength="140">
                                <span class="counter" id="cTitle">0/140</span>
                            </div>
                            <span class="error">Titre requis (10-140 caractères)</span>
                        </div>
                        <div class="field">
                            <label class="label">Thème *</label>
                            <select name="theme" id="aTheme" class="select" required>
                                <option value="">Choisir un thème</option>
                                <option value="Corruption">Corruption</option>
                                <option value="Environnement">Environnement</option>
                                <option value="Santé publique">Santé publique</option>
                                <option value="Droits humains">Droits humains</option>
                                <option value="Économie souterraine">Économie souterraine</option>
                                <option value="Politique">Politique</option>
                                <option value="Technologie">Technologie</option>
                            </select>
                        </div>
                        <div class="field">
                            <label class="label">Format souhaité *</label>
                            <select name="format" id="aFormat" class="select" required>
                                <option value="Article long">Article long</option>
                                <option value="Vidéo">Vidéo</option>
                                <option value="Podcast">Podcast</option>
                                <option value="Infographie">Infographie</option>
                                <option value="Série multimédia">Série multimédia</option>
                            </select>
                        </div>
                        <div id="fAngle" class="field" style="grid-column:span 2">
                            <label class="label">Angle journalistique (30-1200 caractères) *</label>
                            <div class="control">
                                <textarea name="angle" id="aAngle" class="textarea"
                                    placeholder="Décrivez l'angle, les questions centrales, le contexte..." required minlength="30" maxlength="1200"></textarea>
                                <span class="counter" id="cAngle">0/1200</span>
                            </div>
                            <span class="hint">Expliquez pourquoi cette enquête est importante et quelle est votre
                                approche.</span>
                            <span class="error">Angle requis (30-1200 caractères)</span>
                        </div>
                        <div class="field" style="grid-column:span 2">
                            <label class="label">Sources disponibles (optionnel)</label>
                            <div class="control">
                                <textarea name="sources" id="aSources" class="textarea" placeholder="Décrivez vos sources, documents, contacts..."
                                    maxlength="1600"></textarea>
                                <span class="counter" id="cSources">0/1600</span>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Budget estimé (FCFA)</label>
                            <input type="number" name="budget" id="aBudget" class="input"
                                placeholder="Ex. 5000000" min="0" max="999999999">
                        </div>
                        <div class="field">
                            <label class="label">Durée estimée (semaines)</label>
                            <input type="number" name="estimated_weeks" id="aWeeks" class="input"
                                placeholder="Ex. 8" min="1" max="52">
                        </div>
                        <div class="field" style="grid-column:span 2">
                            <label class="label">Besoins spécifiques</label>
                            <textarea name="needs" id="aNeeds" class="textarea"
                                placeholder="Décrivez vos besoins matériels, logistiques, humains..." maxlength="1000"></textarea>
                        </div>
                        <div class="field" style="grid-column:span 2">
                            <label class="label">Fichiers joints (max 10 Mo par fichier)</label>
                            <div class="upload" id="dropzone">
                                <input type="file" name="files[]" id="aFiles" multiple
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <p>📎 Glissez vos fichiers ici ou <strong>cliquez pour parcourir</strong></p>
                                <p class="legend" id="filesList">Aucun fichier sélectionné.</p>
                            </div>
                        </div>
                        <div class="actions" style="grid-column:span 2">
                            <button type="button" class="btn ghost" id="btnDraft">Enregistrer le brouillon</button>
                            <button type="submit" class="btn primary">Envoyer la proposition</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel" style="margin-top:20px">
                <header>Mes propositions</header>
                <div class="body">
                    <div class="list" id="proposalList">
                        <p class="legend">Connectez-vous ou entrez votre email ci-dessus pour voir vos propositions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact -->
    <section id="impact" class="section">
        <div class="container">
            <div class="panel">
                <header>📈 Impact des enquêtes passées</header>
                <div class="body">
                    <p class="legend" style="text-align:center;padding:40px">Section en construction. Les premières
                        enquêtes publiées apparaîtront ici avec leurs impacts (réformes, poursuites, changements de
                        politique...).</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Guide -->
    <div class="guide-modal" id="modalGuide">
        <div class="guide-modal-container">
            <div class="guide-modal-header">
                <h2 class="guide-modal-title">Guide éditorial — LCM Investigation</h2>
                <button class="btn ghost" onclick="closeModal()">Fermer</button>
            </div>

            <div class="guide-modal-body">
                <div class="guide-section">
                    <h3 class="guide-section-title">Principes</h3>
                    <ul class="guide-list">
                        <li>Indépendance, transparence et droit de réponse</li>
                        <li>Protection renforcée des sources (chiffrement, anonymisation)</li>
                        <li>Vérification multi-sources, traçabilité des preuves</li>
                    </ul>
                </div>

                <div class="guide-section">
                    <h3 class="guide-section-title">Procédure</h3>
                    <ol class="guide-list">
                        <li>Pitch & angle validés par la direction</li>
                        <li>Feuille de route : méthodo, planning, budget</li>
                        <li>Collecte des preuves, confrontation, droit de réponse</li>
                        <li>Comité éditorial : validation & plan de diffusion</li>
                    </ol>
                </div>

                <div class="guide-section">
                    <h3 class="guide-section-title">Méthodologie</h3>
                    <p class="guide-text">Toute enquête suit un protocole rigoureux : vérification des sources, croisement
                        des informations, droit de réponse, relecture par un comité éditorial.</p>
                </div>
            </div>
        </div>
    </div>

<script>
    const userEmail = @json($userEmail ?? null);

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type}`;
        notification.innerHTML = `<span>${message}</span><button class="alert-close" onclick="this.parentElement.remove()">×</button>`;

        let container = document.getElementById('notification-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'notification-container';
            document.body.appendChild(container);
        }

        container.appendChild(notification);
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }

    async function loadUserProposals() {
        if (!userEmail) {
            document.getElementById('proposalList').innerHTML = '<p class="legend">Connectez-vous pour voir vos propositions.</p>';
            return;
        }
        try {
            const response = await fetch('{{ route('investigation.myProposals') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({email: userEmail})
            });
            const data = await response.json();
            if (data.success && data.proposals.length > 0) {
                renderProposals(data.proposals);
            } else {
                document.getElementById('proposalList').innerHTML = '<p class="legend">Vous n\'avez aucune proposition pour le moment.</p>';
            }
        } catch (error) {
            console.error('Erreur:', error);
        }
    }

    function renderProposals(proposals) {
        const listHtml = proposals.map(p => `
            <div class="item">
                <div class="meta">
                    <span class="pill">${p.format}</span>
                    <span class="status ${p.status}">${p.status_label}</span>
                </div>
                <h4 style="margin:6px 0">${p.title}</h4>
                <p class="legend" style="margin:4px 0">Thème : ${p.theme}</p>
                <div class="meta" style="margin-top:8px">
                    <span class="legend">Soumis le ${p.created_at}</span>
                    ${p.budget ? `<span><strong>${new Intl.NumberFormat('fr-FR').format(p.budget)} FCFA</strong></span>` : ''}
                </div>
                ${p.rejection_reason ? `<p style="color:var(--red);font-size:12px;margin-top:6px">Motif : ${p.rejection_reason}</p>` : ''}
            </div>
        `).join('');
        document.getElementById('proposalList').innerHTML = listHtml;
    }

    document.querySelectorAll('.tab').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(target).classList.add('active');
            if (target === 'submit') loadUserProposals();
        });
    });

    const counters = [
        {el: '#aTitle', c: '#cTitle', max: 140},
        {el: '#aAngle', c: '#cAngle', max: 1200},
        {el: '#aSources', c: '#cSources', max: 1600}
    ];
    counters.forEach(({el, c, max}) => {
        const input = document.querySelector(el);
        const counter = document.querySelector(c);
        const update = () => counter.textContent = `${(input.value || '').length}/${max}`;
        input.addEventListener('input', update);
        update();
    });

    function validate() {
        const name = document.querySelector('#aName').value.trim();
        const email = document.querySelector('#aEmail').value.trim();
        const title = document.querySelector('#aTitle').value.trim();
        const angle = document.querySelector('#aAngle').value.trim();
        return name.length >= 3 && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) && title.length >= 10 && angle.length >= 30;
    }

    document.getElementById('btnDraft').addEventListener('click', () => {
        showNotification('Brouillon enregistré', 'success');
    });

    const dz = document.querySelector('#dropzone');
    const inputFiles = document.querySelector('#aFiles');
    const filesList = document.querySelector('#filesList');
    dz.addEventListener('click', () => inputFiles.click());
    inputFiles.addEventListener('change', () => {
        const f = [...inputFiles.files];
        filesList.textContent = f.length ? f.map(x => `${x.name} (${Math.round(x.size/1024)} Ko)`).join(' • ') : 'Aucun fichier sélectionné.';
    });

    document.getElementById('proposalForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        e.stopPropagation();

        if (!validate()) {
            showNotification('Veuillez corriger les champs en rouge', 'error');
            return false;
        }

        const formData = new FormData(e.target);
        const submitBtn = e.target.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Envoi en cours...';

        try {
            const response = await fetch('{{ route("investigation.submit") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            let data = {};
            try {
                data = await response.json();
            } catch (err) {
                data = {success: true, message: 'Proposition soumise avec succès !'};
            }

            if (response.ok || data.success) {
                showNotification(data.message || 'Proposition soumise !', 'success');
                e.target.reset();
                filesList.textContent = 'Aucun fichier sélectionné.';
                counters.forEach(({c}) => document.querySelector(c).textContent = document.querySelector(c).textContent.replace(/^\d+/, '0'));
                setTimeout(() => loadUserProposals(), 1000);
            } else {
                showNotification(data.message || 'Erreur lors de la soumission', 'error');
            }
        } catch (error) {
            showNotification('Erreur réseau. Réessayez.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Envoyer la proposition';
        }

        return false;
    });

    function showProposalDetails(id) { console.log('Details:', id); }
    function supportProposal(id) { console.log('Support:', id); }
    function openModal() { document.getElementById('modalGuide').classList.add('open'); }
    function closeModal() { document.getElementById('modalGuide').classList.remove('open'); }
</script>
@endsection
