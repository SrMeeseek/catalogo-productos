import styles from "./Navbar.module.css";
import ThemeToggle from "./ThemeToggle";

export default function Navbar() {
  return (
    <nav className={styles.nav}>
      <div className={styles.inner}>
        <span className={styles.brand}>Catálogo de Productos</span>
        <div className={styles.right}>
          <a className={styles.link} href="/">Inicio</a>
          <ThemeToggle />
        </div>
      </div>
    </nav>
  );
}
