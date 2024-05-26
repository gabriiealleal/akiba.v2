import usePageName from '@/hooks/usePageName';
import BoasVindas from '@/interfaces/private/components/dashboard/BoasVindas';
import AvisosParaEquipe from '@/interfaces/private/components/dashboard/AvisosParaEquipe';
import AcoesRapidas from '@/interfaces/private/components/dashboard/AcoesRapidas';
import StatusSiteRadio from '@/interfaces/private/components/dashboard/StatusSiteRadio';
import MinhasTarefas from '@/interfaces/private/components/dashboard/MinhasTarefas';
import UltimasMaterias from '@/interfaces/private/components/dashboard/UltimasMaterias';
import Calendario from '@/interfaces/private/components/dashboard/Calendario';

const Dashboard = () => {
    usePageName('Dashboard');
    
    return (
        <>
            <BoasVindas/>
            <AvisosParaEquipe/>
            <AcoesRapidas/>
            <StatusSiteRadio/>
            <MinhasTarefas/>
            <UltimasMaterias/>
            <Calendario/>
        </>
    );
}

export default Dashboard;