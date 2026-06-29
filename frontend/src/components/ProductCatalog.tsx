"use client";

import { useState, useEffect, useCallback } from "react";
import type { PaginatedProducts } from "@/types/product";
import ProductCard from "./ProductCard";
import styles from "./ProductCatalog.module.css";

export default function ProductCatalog({ initial }: { initial: PaginatedProducts }) {
  const [query, setQuery] = useState("");
  const [page, setPage] = useState(1);
  const [result, setResult] = useState<PaginatedProducts>(initial);
  const [loading, setLoading] = useState(false);

  const fetch_ = useCallback(async (q: string, p: number) => {
    setLoading(true);
    // console.log('fetch', q, p)
    const params = new URLSearchParams();
    if (q) params.set("q", q);
    params.set("page", String(p));
    const res = await fetch(`http://127.0.0.1:8000/api/products?${params}`, { cache: "no-store" });
    if (!res.ok) {
      console.error('Error cargando productos', res.status);
      setResult({ data: [], current_page: 1, last_page: 1, total: 0 });
    } else {
      setResult(await res.json());
    }
    setLoading(false);
  }, []);

  useEffect(() => {
    const timer = setTimeout(() => fetch_(query, page), 300);
    return () => clearTimeout(timer);
  }, [query, page, fetch_]);

  const handleQuery = (q: string) => {
    setQuery(q);
    setPage(1);
  };

  const pages = Array.from({ length: result.last_page }, (_, i) => i + 1);

  return (
    <>
      <div className={styles.searchWrapper}>
        <input
          type="text"
          className={styles.search}
          placeholder="Buscar por nombre o marca..."
          value={query}
          onChange={(e) => handleQuery(e.target.value)}
        />
        {query && (
          <button className={styles.clear} onClick={() => handleQuery("")}>✕</button>
        )}
      </div>

      {loading ? (
        <p className={styles.empty}>Buscando...</p>
      ) : result.data.length === 0 ? (
        <p className={styles.empty}>
          {query ? `No se encontraron productos para "${query}".` : "No hay productos registrados aún."}
        </p>
      ) : (
        <>
          <div className={styles.grid}>
            {result.data.map((product) => (
              <ProductCard key={product.id} product={product} />
            ))}
          </div>

          {result.last_page > 1 && (
            <div className={styles.pagination}>
              <button
                className={styles.pageBtn}
                onClick={() => setPage((p) => p - 1)}
                disabled={page === 1}
              >
                ‹ Anterior
              </button>

              {pages.map((p) => (
                <button
                  key={p}
                  className={`${styles.pageBtn} ${p === page ? styles.active : ""}`}
                  onClick={() => setPage(p)}
                >
                  {p}
                </button>
              ))}

              <button
                className={styles.pageBtn}
                onClick={() => setPage((p) => p + 1)}
                disabled={page === result.last_page}
              >
                Siguiente ›
              </button>
            </div>
          )}
        </>
      )}
    </>
  );
}
