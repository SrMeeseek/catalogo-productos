"use client";

import { useEffect, useState } from "react";
import styles from "./Navbar.module.css";

export default function ThemeToggle() {
  const [dark, setDark] = useState<boolean | null>(null);

  useEffect(() => {
    setDark(document.documentElement.classList.contains("dark"));
  }, []);

  const toggle = () => {
    const next = !dark;
    setDark(next);
    document.documentElement.classList.toggle("dark", next);
    localStorage.setItem("theme", next ? "dark" : "light");
  };

  return (
    <button onClick={toggle} className={styles.themeToggle} aria-label="Alternar modo">
      {dark === true ? "☀️ Claro" : "🌙 Oscuro"}
    </button>
  );
}
