<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Employment Opportunities</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap');

    body {
      margin: 0;
      font-family: 'Times New Roman', serif;
      background-color: white;
      color: black;
      min-height: 100vh;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 40px 80px;
    }
    .logo {
      display: flex;
      align-items: center;
      gap: 5px;
      user-select: none;
    }
    .logo .e {
      font-weight: bold;
      font-size: 40px;
      color: #8B8BE6;
    }
    .logo .c {
      font-weight: bold;
      font-size: 40px;
      color: #00E676;
    }
    .logo .s {
      font-weight: bold;
      font-size: 40px;
      color: #0066FF;
    }
    .logo svg {
      width: 28px;
      height: 28px;
      stroke: #FF9800;
      stroke-width: 3;
      stroke-linecap: round;
      stroke-linejoin: round;
      fill: none;
    }
    .seal {
      width: 80px;
      height: 80px;
      object-fit: contain;
    }
    main {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 0 80px 40px 80px;
      gap: 40px;
      flex-wrap: wrap;
    }
    .content {
      max-width: 480px;
      flex-grow: 1;
    }
    h2 {
      color: #8B8BE6;
      font-weight: 600;
      font-size: 24px;
      line-height: 1.4;
      margin-bottom: 24px;
    }
    p {
      font-family: 'Times New Roman', serif;
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 32px;
    }
    details {
      border: 1px solid #d1d5db;
      max-width: 280px;
      font-family: inherit;
      font-size: 16px;
    }
    summary {
      list-style: none;
      cursor: pointer;
      padding: 8px 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      user-select: none;
    }
    summary::-webkit-details-marker {
      display: none;
    }
    summary svg {
      width: 20px;
      height: 20px;
      stroke: black;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
      fill: none;
      transition: transform 0.3s ease;
    }
    details[open] summary svg {
      transform: rotate(180deg);
    }
    ul {
      margin: 0;
      padding: 0;
      list-style: none;
      border-top: 1px solid #d1d5db;
    }
    ul li {
      border-top: 1px solid #d1d5db;
      padding: 8px 0;
      font-weight: bold;
      text-align: center;
      cursor: pointer;
      user-select: none;
    }
    ul li:hover {
      background-color: #f3f4f6;
    }
    ul li a {
      text-decoration: none;
      color: inherit;
      display: block;
      width: 100%;
      height: 100%;
    }
    .image-container {
      flex-grow: 1;
      max-width: 400px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .image-container img {
      max-width: 100%;
      height: auto;
      display: block;
    }
    @media (max-width: 768px) {
      header {
        padding: 24px 32px;
      }
      main {
        padding: 0 32px 24px 32px;
        flex-direction: column;
        align-items: flex-start;
      }
      .content, .image-container {
        max-width: 100%;
        flex-grow: unset;
      }
      h2 {
        font-size: 20px;
      }
    }
  </style>
</head>
<body>
  <header>
    
    <img
      src="193b33e5-8839-46b6-98e2-d56d3877a21c_removalai_preview.png"
      class="seal"
      width="80"
      height="80"
    />
  </header>
  <main>
    <section class="content">
      <h2>Employment Opportunities for College Students at OMSC – Mamburao Campus</h2>
      <p>
        We are committed to supporting our students beyond academics. Our Student Employment Program offers valuable opportunities for college students to gain work experience, develop professional skills, and earn income while pursuing their education.
      </p>
      <details>
        <summary>
          Select type of user
          <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </summary>
        <ul>
          <li><a href="login_Student.php">Student</a></li>
          <li><a href="login_Org.php">Organization</a></li>
          <li><a href="Login_admin.php">Admin</a></li>
        </ul>
      </details>
    </section>
    <section class="image-container">
      <img
        src="JOB.avif"
        width="400"
        height="300"
      />
    </section>
  </main>
</body>
</html>