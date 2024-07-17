import React, { useState, useEffect } from 'react';

const MaintenancePage = () => {
    const [siteInfo, setSiteInfo] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchSiteInfo = async () => {
            try {
                const response = await fetch('http://localhost:5000/api/site-info');
                if (!response.ok) {
                    throw new Error('Failed to fetch site info');
                }
                const data = await response.json();
                setSiteInfo(data);
                setLoading(false);
            } catch (err) {
                setError(err.message);
                setLoading(false);
            }
        };

        fetchSiteInfo();
    }, []);

    if (loading) {
        return (
            <div className="flex min-h-screen items-center justify-center bg-gray-900 text-white">
                <div className="text-center">
                    <h1 className="text-4xl font-bold mb-4">Loading...</h1>
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="flex min-h-screen items-center justify-center bg-gray-900 text-white">
                <div className="text-center">
                    <h1 className="text-4xl font-bold mb-4">Error</h1>
                    <p className="text-lg mb-8">{error}</p>
                </div>
            </div>
        );
    }

    return (
        <div className="flex min-h-screen items-center justify-center bg-gray-900 text-white">
            <div className="text-center">
                <h1 className="text-4xl font-bold mb-4">{siteInfo?.siteName} est en cours de construction</h1>
                <p className="text-lg mb-8">Nous revenons bientôt !</p>
            </div>
        </div>
    );
};

export default MaintenancePage;
