import LoungeLayout from "@/Lounge/LoungeLayout";
import { Link } from "@inertiajs/react";

export default function Lounge({auth, canLogin, canRegister}){
    return (
        <LoungeLayout>
            {/* PRELOADER */}
            <div className="">
                
            </div>
        </LoungeLayout>
    );
}