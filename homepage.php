<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>Employment Opportunities</title>
  <link href="view_c/css/bootstrap.min.css" rel="stylesheet" />
  <script src="view_c/js/bootstrap.min.js"></script>
  <script src="view_c/node_modules/boxicons/dist/boxicons.js"></script>
  <script src="view_c/js/axios.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Roboto Slab', serif;
      background-color: white;
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
    h2 {
      color: #8b8bf7;
      font-weight: 600;
      font-size: 1.75rem;
      line-height: 1.3;
    }
    p {
      font-family: Georgia, serif;
      font-size: 1rem;
      line-height: 1.5;
      margin-bottom: 2rem;
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
  </style>
</head>
<body>
<header class="d-flex justify-content-between align-items-start p-4">
<img
      src="image/logo.png"
      class="seal"
      width="80"
      height="80"
    />
    <img alt="Seal of Occidental Mindoro State College, circular emblem with yellow and blue colors" class="img-fluid" height="80" src="https://storage.googleapis.com/a1aa/image/23a8b205-cadc-45f0-bcc5-ccc23b858546.jpg" width="80" />
  </header>
  <main class="container d-flex flex-column flex-md-row align-items-center align-items-md-start justify-content-between gap-4 px-4 px-md-5">
    <section class="flex-grow-1" style="max-width: 28rem;">
      <h2 class="mb-4">
        Employment Opportunities for College Students at OMSC – Mamburao Campus
      </h2>
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
          <li><a href="Login_signup/login_Student.php">Student</a></li>
          <li><a href="Login_signup/login_Org.php">Organization</a></li>
          <li><a href="Login_signup/login_admin.html">Admin</a></li>
        </ul>
      </details>
    </section>
    <section>
      <img alt="Illustration of hands holding a tablet showing a job offer document with a magnifying glass highlighting the text 'JOB OFFER', surrounded by papers and an envelope" class="img-fluid" height="280" src="image/JOB.avif" width="400" />
    </section>
  </main>
</body>
</html>