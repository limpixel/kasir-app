import { useState, useEffect } from 'react';
import { usePage } from '@inertiajs/react';

export default function HistoryTab() {
    const { auth } = usePage().props;
    const [transactions, setTransactions] = useState([]);
    const [loading, setLoading] = useState(true);

    // Ambil transaksi hanya untuk customer ini
    useEffect(() => {
        fetchCustomerTransactions();
    }, []);

    const fetchCustomerTransactions = async () => {
        try {
            const response = await fetch(route('profile.customer.transactions', { userId: auth.user.id }));
            if (response.ok) {
                const data = await response.json();
                setTransactions(data.transactions || []);
            }
        } catch (error) {
            console.error('Gagal mengambil riwayat transaksi:', error);
        } finally {
            setLoading(false);
        }
    };

    const getStatusClass = (status) => {
        switch (status) {
            case 'completed':
                return 'bg-green-500/20 text-green-300';
            case 'pending':
                return 'bg-yellow-500/20 text-yellow-300';
            default:
                return 'bg-red-500/20 text-red-300';
        }
    };

    if (loading) {
        return (
            <div className="text-center py-12">
                <p className="text-gray-600 text-xl">Memuat...</p>
            </div>
        );
    }

    if (transactions.length === 0) {
        return (
            <div className="text-center py-12">
                <p className="text-gray-600 text-xl mb-4">Belum ada riwayat transaksi</p>
            </div>
        );
    }

    return (
        <div className="space-y-6">
            {transactions.map((transaction) => (
                <article
                    key={transaction.id}
                    className="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 shadow-sm"
                >
                    {/* HEADER */}
                    <header className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div>
                            <p className="text-lg sm:text-xl font-semibold text-gray-900">
                                Invoice: {transaction.invoice}
                            </p>
                            <p className="text-gray-600 mt-1">
                                {new Date(transaction.created_at).toLocaleDateString('id-ID')}
                            </p>
                        </div>

                        <div className="flex justify-center items-center gap-3">
                            <span
                                className={`px-3 py-1 rounded-full text-sm font-semibold uppercase tracking-wide ${getStatusClass(transaction.status)}`}
                            >
                                {transaction.status === 'completed' ? 'Selesai' : 
                                 transaction.status === 'pending' ? 'Pending' : 'Dibatalkan'}
                            </span>

                            <button
                                onClick={() =>
                                    window.open(
                                        `/transactions/${transaction.invoice}/print`,
                                        "_blank",
                                    )
                                }
                                className="px-4 py-1.5 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition"
                            >
                                Cetak
                            </button>
                        </div>
                    </header>

                    {/* INFO */}
                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <div className="sm:col-span-2 bg-gray-50 rounded-xl p-4 space-y-1">
                            <p className="text-gray-800">
                                <span className="text-gray-600">Nama:</span> {transaction.customer_name}
                            </p>
                            <p className="text-gray-800">
                                <span className="text-gray-600">WhatsApp:</span> {transaction.customer_phone}
                            </p>
                            <p className="text-gray-800">
                                <span className="text-gray-600">Alamat:</span> {transaction.customer_address}
                            </p>
                        </div>

                        <div className="bg-gray-50 rounded-xl p-4">
                            <p className="text-gray-600 text-xs">Metode Pembayaran</p>
                            <p className="text-gray-800 font-medium mb-4">{transaction.payment_method}</p>

                            <p className="text-gray-600 text-xs">Total</p>
                            <p className="text-lg font-bold text-gray-800">
                                Rp {Number(transaction.grand_total).toLocaleString('id-ID')}
                            </p>
                        </div>
                    </div>

                    {/* ITEMS */}
                    <div className="overflow-hidden rounded-xl border border-gray-200">
                        <table className="w-full text-left border-collapse">
                            <thead className="bg-gray-50">
                                <tr className="text-xs uppercase tracking-wide text-gray-600">
                                    <th className="py-3 px-4">Produk</th>
                                    <th className="py-3 px-4 w-20 text-center">Jumlah</th>
                                    <th className="py-3 px-4 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                {transaction.items.map((item, idx) => (
                                    <tr
                                        key={idx}
                                        className="border-t border-gray-100 text-gray-700"
                                    >
                                        <td className="py-3 px-4">{item.product_name}</td>
                                        <td className="py-3 px-4 text-center">{item.qty}</td>
                                        <td className="py-3 px-4 text-right">
                                            Rp {Number(item.subtotal).toLocaleString('id-ID')}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </article>
            ))}
        </div>
    );
}